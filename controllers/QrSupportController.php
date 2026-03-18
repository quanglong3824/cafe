<?php
// ============================================================
// QrSupportController — Aurora Restaurant
// ============================================================

require_once BASE_PATH . '/models/Order.php';
require_once BASE_PATH . '/models/OrderNotification.php';

class QrSupportController extends Controller
{
    private Order $orderModel;
    private OrderNotification $notifModel;

    public function __construct()
    {
        $this->orderModel = new Order();
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

    public function callWaiter(): void
    {
        $tableId = $this->requireCustomer();
        $order = $this->orderModel->findOpenOrderByTable($tableId);
        $orderId = $order ? $order['id'] : 0; // If no order yet, order_id is 0

        $this->notifModel->create([
            'order_id' => $orderId,
            'table_id' => $tableId,
            'notification_type' => 'support_request',
            'title' => "Bàn $tableId: Cần hỗ trợ",
            'message' => "Khách tại bàn $tableId đang gọi nhân viên."
        ]);

        $this->json(['success' => true, 'message' => 'Yêu cầu của quý khách đã được gửi đến nhân viên.']);
    }

    public function requestBill(): void
    {
        $tableId = $this->requireCustomer();
        $order = $this->orderModel->findOpenOrderByTable($tableId);
        
        if (!$order) {
            $this->json(['error' => 'Chưa có order nào để thanh toán'], 400);
            return;
        }

        $orderId = $order['id'];

        // Update order notes or a specific field to indicate payment request
        // Using a custom note or status for immediate visual cue in admin
        $this->orderModel->appendNote($orderId, "KHÁCH YÊU CẦU THANH TOÁN");

        $this->notifModel->create([
            'order_id' => $orderId,
            'table_id' => $tableId,
            'notification_type' => 'payment_request',
            'title' => "Bàn $tableId: Yêu cầu thanh toán",
            'message' => "Khách tại bàn $tableId yêu cầu tính tiền."
        ]);

        $this->json(['success' => true, 'message' => 'Yêu cầu thanh toán đã được gửi. Nhân viên sẽ đến hỗ trợ quý khách ngay.']);
    }
}
