<?php
// ============================================================
// QrMenuController — Aurora Restaurant
// ============================================================

require_once BASE_PATH . '/models/QrTable.php';
require_once BASE_PATH . '/models/Table.php';
require_once BASE_PATH . '/models/MenuItem.php';
require_once BASE_PATH . '/models/MenuCategory.php';
require_once BASE_PATH . '/models/Order.php';
require_once BASE_PATH . '/models/CustomerSession.php';
require_once BASE_PATH . '/models/OrderNotification.php';

class QrMenuController extends Controller
{
    private QrTable $qrModel;
    private Table $tableModel;
    private MenuItem $menuModel;
    private MenuCategory $categoryModel;
    private Order $orderModel;
    private CustomerSession $sessionModel;
    private OrderNotification $notifModel;

    public function __construct()
    {
        $this->qrModel = new QrTable();
        $this->tableModel = new Table();
        $this->menuModel = new MenuItem();
        $this->categoryModel = new MenuCategory();
        $this->orderModel = new Order();
        $this->sessionModel = new CustomerSession();
        $this->notifModel = new OrderNotification();
    }

    /** Handle short QR links: /q?t=TOKEN */
    public function shortLink(): void
    {
        $token = $_GET['t'] ?? '';
        if (!$token) {
            $this->view('404', ['message' => 'Mã QR thiếu mã định danh.']);
            return;
        }

        $qrTable = $this->qrModel->findByToken($token);
        if (!$qrTable) {
            $this->view('404', ['message' => 'Mã QR không tồn tại hoặc đã hết hạn.']);
            return;
        }

        // Redirect to full menu URL
        $this->redirect("/qr/menu?table_id=" . $qrTable['table_id'] . "&token=" . $qrTable['qr_hash']);
    }

    /** View menu for customer */
    public function index(): void
    {
        try {
            if (session_status() === PHP_SESSION_NONE) session_start();

            $tableId = (int)($_GET['table_id'] ?? 0);
            $token = $_GET['token'] ?? '';

            if (!$tableId || !$token) {
                $this->view('404', ['message' => 'Mã QR không hợp lệ hoặc thiếu thông tin bàn.']);
                return;
            }

            $qrTable = $this->qrModel->findByToken($token);
            if (!$qrTable || $qrTable['table_id'] != $tableId) {
                $this->view('404', ['message' => 'Mã QR đã hết hạn hoặc không hợp lệ.']);
                return;
            }

            // --- XỬ LÝ ĐỔI BÀN (TABLE SWITCHING) ---
            $oldTableId = $_SESSION['customer_table_id'] ?? null;
            if ($oldTableId && $oldTableId != $tableId) {
                $oldOrder = $this->orderModel->findOpenOrderByTable($oldTableId);
                if ($oldOrder) {
                    $oldItems = $this->orderModel->getItems($oldOrder['id']);
                    // Nếu bàn cũ CHƯA có món nào, tự động hủy bàn cũ để sang bàn mới
                    if (empty($oldItems)) {
                        $this->orderModel->execute("UPDATE orders SET status = 'closed', note = 'Khách đổi sang bàn $tableId' WHERE id = ?", [$oldOrder['id']]);
                        $this->tableModel->close($oldTableId);
                    } else {
                        // Nếu bàn cũ ĐÃ CÓ món, cảnh báo khách không được tự ý đổi bàn
                        $this->view('404', [
                            'message' => "Bạn đang có đơn hàng tại bàn " . $oldTableId . ". <br>Vui lòng thanh toán hoặc nhờ nhân viên hỗ trợ nếu muốn đổi bàn."
                        ]);
                        return;
                    }
                }
            }

            // --- XỬ LÝ QUÉT ĐÈ / SESSION HẾT HẠN (5 PHÚT) ---
            $table = $this->tableModel->findById($tableId);
            if ($table && $table['status'] === 'occupied') {
                $openOrder = $this->orderModel->findOpenOrderByTable($tableId);
                if ($openOrder) {
                    $items = $this->orderModel->getItems($openOrder['id']);
                    $minutesSinceOpen = (time() - strtotime($openOrder['opened_at'])) / 60;
                    
                    // Nếu bàn bận nhưng KHÔNG có món và đã quá 5 phút -> Coi như bàn trống ảo
                    if (empty($items) && $minutesSinceOpen > 5) {
                        $this->orderModel->execute("UPDATE orders SET status = 'closed', note = 'Hết hạn 5 phút không đặt món' WHERE id = ?", [$openOrder['id']]);
                        $this->tableModel->close($tableId);
                        $table['status'] = 'available'; // Reset trạng thái để tiếp tục xử lý bên dưới
                    }
                }
            }

            // Increment scan count
            $this->qrModel->incrementScanCount($qrTable['id']);

            // Set customer session
            $this->setupCustomerSession($tableId, $token);

            $table = $this->tableModel->findById($tableId); // Reload table status
            if (!$table) {
                $this->view('404', ['message' => 'Không tìm thấy thông tin bàn.']);
                return;
            }

            $categories = $this->categoryModel->getAll();
            $menuItems = $this->menuModel->getAllActive();

            // Get the most recent order for this table
            $lastOrder = $this->orderModel->findLastOrderByTable($tableId);
            
            // If the last order is closed within a reasonable time (e.g., 2 hours)
            if ($lastOrder && $lastOrder['status'] === 'closed') {
                $closedTime = strtotime($lastOrder['closed_at']);
                if ((time() - $closedTime) < 7200) {
                    $orderItems = $this->orderModel->getItems($lastOrder['id']);
                    if (!empty($orderItems)) {
                        $this->view('layouts/public', [
                            'view' => 'orders/paid_bill',
                            'pageTitle' => 'Hóa đơn đã thanh toán',
                            'table' => $table,
                            'order' => $lastOrder,
                            'items' => $orderItems,
                            'isCustomer' => true
                        ]);
                        return;
                    }
                }
            }

            // Get open order for this table if exists
            $openOrder = $this->orderModel->findOpenOrderByTable($tableId);
            $orderItems = [];
            $orderId = 0;
            
            if ($openOrder) {
                $orderId = $openOrder['id'];
                $orderItems = $this->orderModel->getItems($orderId);
            }

            // Notify staff about QR scan
            $this->notifModel->create([
                'order_id' => $orderId ?: null,
                'table_id' => $tableId,
                'notification_type' => 'scan_qr',
                'title' => "Bàn " . ($table['name'] ?? $tableId) . ": Khách đang xem menu",
                'message' => "Khách vừa quét mã QR tại bàn " . ($table['name'] ?? $tableId)
            ]);
            
            $this->view('layouts/public', [
                'view' => 'menu/customer',
                'pageTitle' => 'Thực đơn bàn ' . ($table['name'] ?? $tableId),
                'table' => $table,
                'categories' => $categories,
                'menuItems' => $menuItems,
                'openOrder' => $openOrder,
                'orderItems' => $orderItems,
                'isCustomer' => true
            ]);
        } catch (\Throwable $e) {
            echo "<h1>Hệ thống gặp lỗi (500)</h1>";
            echo "<p>Lỗi: " . $e->getMessage() . "</p>";
            echo "<p>File: " . $e->getFile() . " trên dòng " . $e->getLine() . "</p>";
            exit;
        }
    }

    private function setupCustomerSession(int $tableId, string $token): void
    {
        // Set session cookie lifetime to 24 hours
        $lifetime = 24 * 3600;
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => $lifetime,
                'path' => '/',
                'domain' => $_SERVER['HTTP_HOST'],
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            session_start();
        }

        $sessionId = session_id();
        
        // Always call create() which uses ON DUPLICATE KEY UPDATE internally
        // to handle existing/expired/inactive sessions gracefully
        $this->sessionModel->create([
            'session_id' => $sessionId,
            'table_id' => $tableId
        ]);

        $_SESSION['customer_table_id'] = $tableId;
        $_SESSION['qr_token'] = $token;
    }

    /** Add item to cart (temporary session or draft order) */
    public function addToCart(): void
    {
        $this->requireCustomer();
        
        $tableId = $_SESSION['customer_table_id'];
        $menuItemId = (int)$_POST['menu_item_id'];
        $quantity = (int)($_POST['quantity'] ?? 1);
        $note = $_POST['note'] ?? '';

        $this->json(['success' => true, 'message' => 'Đã thêm vào giỏ hàng']);
    }

    private function requireCustomer(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['customer_table_id'])) {
            $this->json(['error' => 'Vui lòng quét mã QR để tiếp tục'], 401);
            exit;
        }
    }
}
