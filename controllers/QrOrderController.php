<?php
// ============================================================
// QrOrderController — Aurora Cafe
// ============================================================

require_once BASE_PATH . '/models/Order.php';
require_once BASE_PATH . '/models/Table.php';
require_once BASE_PATH . '/models/CustomerSession.php';
require_once BASE_PATH . '/models/OrderNotification.php';

class QrOrderController extends Controller
{
    private Order $orderModel;
    private Table $tableModel;
    private CustomerSession $sessionModel;
    private OrderNotification $notifModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->tableModel = new Table();
        $this->sessionModel = new CustomerSession();
        $this->notifModel = new OrderNotification();
    }

    private function requireCustomer(): int
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['customer_table_id'])) {
            $this->json(['error' => 'Vui lòng quét mã QR để tiếp tục'], 401);
            exit;
        }
        return $_SESSION['customer_table_id'];
    }

    /** Submit customer order */
    public function submit(): void
    {
        $tableId = $this->requireCustomer();
        $currentSessionId = session_id();
        $cartData = json_decode($_POST['cart'] ?? '[]', true);
        $notes = $_POST['notes'] ?? '';

        if (empty($cartData)) {
            $this->json(['error' => 'Giỏ hàng trống'], 400);
            return;
        }

        try {
            // Check table status
            $table = $this->tableModel->findById($tableId);
            if (!$table) {
                $this->json(['error' => 'Không tìm thấy bàn'], 404);
                return;
            }

            // Check if open order exists
            $order = $this->orderModel->findOpenOrderByTable($tableId);
            $isNewOrder = false;

            if (!$order) {
                // Check if table is occupied (but no order? possible if waiter manually opened it)
                // If it is available, we open it
                if ($table['status'] === 'available') {
                    $this->tableModel->open($tableId);
                }

                // Create new order with session_id
                $orderId = $this->orderModel->create([
                    'table_id' => $tableId,
                    'guest_count' => (int)($_POST['guest_count'] ?? 1),
                    'note' => $notes,
                    'order_source' => 'customer_qr',
                    'session_id' => $currentSessionId,
                    'status' => 'open'
                ]);
                $isNewOrder = true;
            } else {
                // If table is occupied, but this session is different from the one that opened the order
                // Allow it IF it is a new scan at the table, but we should be careful.
                // For simplicity, if they have a valid qr_token in session, we allow them to join.
                $orderId = $order['id'];
                
                // If the session_id is different, we could block it if we want strict anti-spam
                // but that would prevent a group of friends from ordering together.
                // So we allow it as long as they have the correct qr_token (meaning they scanned the QR).
                
                // Append notes if any
                if ($notes) {
                    $this->orderModel->appendNote($orderId, $notes);
                }
            }

            // Add items to order
            foreach ($cartData as $item) {
                $this->orderModel->addItem($orderId, [
                    'menu_item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'note' => $item['note'] ?? '',
                    'status' => 'pending',
                    'customer_id' => $currentSessionId,
                    'submitted_at' => date('Y-m-d H:i:s')
                ]);
            }

            // Create notification for waiters
            $this->notifModel->create([
                'order_id' => $orderId,
                'table_id' => $tableId,
                'notification_type' => $isNewOrder ? 'new_order' : 'order_item',
                'title' => $isNewOrder ? "Bàn " . ($table['name'] ?? $tableId) . ": Order mới" : "Bàn " . ($table['name'] ?? $tableId) . ": Thêm món mới",
                'message' => $isNewOrder ? "Khách đã gửi order mới qua QR." : "Khách đã gửi thêm món qua QR."
            ]);

            $this->json([
                'success' => true, 
                'order_id' => $orderId, 
                'message' => 'Gửi order thành công! Vui lòng chờ nhân viên xác nhận.'
            ]);

        } catch (Exception $e) {
            $this->json(['error' => 'Lỗi xử lý order: ' . $e->getMessage()], 500);
        }
    }

    /** View order status */
    public function status(): void
    {
        $tableId = $this->requireCustomer();
        $order = $this->orderModel->findOpenOrderByTable($tableId);
        
        if (!$order) {
            $this->view('layouts/public', [
                'view' => 'orders/status',
                'pageTitle' => 'Trạng thái Order',
                'message' => 'Hiện tại chưa có order nào đang mở cho bàn này.'
            ]);
            return;
        }

        $items = $this->orderModel->getItems($order['id']);
        
        $this->view('layouts/public', [
            'view' => 'orders/status',
            'pageTitle' => 'Trạng thái Order #' . $order['id'],
            'order' => $order,
            'items' => $items,
            'isCustomer' => true
        ]);
    }

    /** View order history */
    public function history(): void
    {
        $tableId = $this->requireCustomer();
        // Just show items from current session if needed, or all items of the table
        $orders = $this->orderModel->getHistoryByTable($tableId, 5);
        
        $this->view('layouts/public', [
            'view' => 'orders/history',
            'pageTitle' => 'Lịch sử gọi món',
            'orders' => $orders,
            'isCustomer' => true
        ]);
    }
}
