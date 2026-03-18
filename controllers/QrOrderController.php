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

    /** Sync single item from customer cart to server as draft */
    public function syncDraft(): void
    {
        $tableId = $this->requireCustomer();
        $currentSessionId = session_id();
        $itemId = (int)$this->input('item_id');
        $quantity = (int)$this->input('quantity', 1);
        $note = $this->input('note', '');

        if ($itemId <= 0) {
            $this->json(['error' => 'Món không hợp lệ'], 400);
            return;
        }

        try {
            // Find or create order
            $order = $this->orderModel->findOpenOrderByTable($tableId);
            if (!$order) {
                $this->tableModel->open($tableId);
                $orderId = $this->orderModel->create([
                    'table_id' => $tableId,
                    'order_source' => 'customer_qr',
                    'session_id' => $currentSessionId,
                    'status' => 'open'
                ]);
            } else {
                $orderId = $order['id'];
            }

            // Sync item as DRAFT
            // Use syncItem instead of addItem to set exact quantity
            $this->orderModel->syncItem($orderId, [
                'menu_item_id' => $itemId,
                'quantity' => $quantity,
                'note' => $note,
                'status' => 'draft',
                'customer_id' => $currentSessionId
            ]);

            $this->json(['success' => true]);
        } catch (Exception $e) {
            $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /** Remove item from draft (sync delete) */
    public function removeItem(): void
    {
        $tableId = $this->requireCustomer();
        $menuItemId = (int)$this->input('menu_item_id');
        $note = $this->input('note', '');

        try {
            $order = $this->orderModel->findOpenOrderByTable($tableId);
            if ($order) {
                // Find and delete the specific DRAFT item
                $this->db->execute(
                    "DELETE FROM order_items WHERE order_id = ? AND menu_item_id = ? AND note = ? AND status = 'draft'",
                    [$order['id'], $menuItemId, $note]
                );
            }
            $this->json(['success' => true]);
        } catch (Exception $e) {
            $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /** Submit customer order */
    public function submit(): void
    {
        $tableId = $this->requireCustomer();
        $currentSessionId = session_id();
        
        try {
            $order = $this->orderModel->findOpenOrderByTable($tableId);
            if (!$order) {
                $this->json(['error' => 'Không tìm thấy order để xác nhận'], 404);
                return;
            }

            // Convert all DRAFT items from this customer to PENDING
            $this->orderModel->confirmItemsToPending($order['id']);

            // Create notification for waiters
            $table = $this->tableModel->findById($tableId);
            $this->notifModel->create([
                'order_id' => $order['id'],
                'table_id' => $tableId,
                'notification_type' => 'order_item',
                'title' => "Bàn " . ($table['name'] ?? $tableId) . ": Order mới",
                'message' => "Khách vừa chốt danh sách món qua QR."
            ]);

            $this->json([
                'success' => true, 
                'message' => 'Gửi order thành công! Vui lòng chờ nhân viên xác nhận.'
            ]);

        } catch (Exception $e) {
            $this->json(['error' => 'Lỗi xử lý order: ' . $e->getMessage()], 500);
        }
    }

    /** Get current draft items for this table/session */
    public function getDrafts(): void
    {
        $tableId = $this->requireCustomer();
        $order = $this->orderModel->findOpenOrderByTable($tableId);
        
        if (!$order) {
            $this->json(['success' => true, 'items' => []]);
            return;
        }

        $items = $this->orderModel->getItems($order['id']);
        $drafts = array_filter($items, fn($it) => $it['status'] === 'draft');
        
        // Reformat to match customer cart structure
        $formattedDrafts = array_map(fn($it) => [
            'id' => (int)$it['menu_item_id'],
            'name' => $it['item_name'],
            'price' => (float)$it['item_price'],
            'quantity' => (int)$it['quantity'],
            'note' => $it['note']
        ], array_values($drafts));

        $this->json(['success' => true, 'items' => $formattedDrafts]);
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
