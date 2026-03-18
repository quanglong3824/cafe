<?php
// ============================================================
// SupportController — Handle Customer Requests
// ============================================================

require_once BASE_PATH . '/models/Support.php';
require_once BASE_PATH . '/models/OrderNotification.php';
require_once BASE_PATH . '/models/Table.php';

class SupportController extends Controller
{
    private Support $supportModel;
    private OrderNotification $notifModel;
    private Table $tableModel;

    public function __construct()
    {
        $this->supportModel = new Support();
        $this->notifModel = new OrderNotification();
        $this->tableModel = new Table();
    }

    /** POST /support/request — Khách gửi yêu cầu hỗ trợ/thanh toán */
    public function makeRequest(): void
    {
        $tableId = (int) $this->input('table_id');
        $type = $this->input('type'); // 'support' hoặc 'payment'

        if ($tableId <= 0 || !in_array($type, ['support', 'payment'])) {
            $this->json(['ok' => false, 'message' => 'Dữ liệu không hợp lệ.'], 400);
        }

        // 1. Tạo bản ghi trong support_requests
        $requestId = $this->supportModel->createRequest($tableId, $type);

        // 2. Tạo thông báo cho phục vụ (Unified Notification)
        $table = $this->tableModel->findById($tableId);
        $tableName = $table ? $table['name'] : "Bàn $tableId";
        
        $notifType = ($type === 'payment') ? 'payment_request' : 'support_request';
        $title = ($type === 'payment') ? "Yêu cầu thanh toán" : "Cần hỗ trợ";
        $message = "Khách tại $tableName vừa yêu cầu " . ($type === 'payment' ? "tính tiền." : "hỗ trợ trực tiếp.");

        $this->notifModel->create([
            'table_id' => $tableId,
            'notification_type' => $notifType,
            'title' => "$tableName: $title",
            'message' => $message
        ]);

        $this->json(['ok' => true, 'message' => 'Đã gửi yêu cầu thành công. Nhân viên sẽ đến ngay.']);
    }

    /** POST /support/resolve — Nhân viên xác nhận hoàn thành (Old API for compatibility) */
    public function resolve(): void
    {
        Auth::requireRole(ROLE_WAITER, ROLE_ADMIN, ROLE_IT);
        $id = $this->input('id');

        if ($id) {
            $this->supportModel->resolveRequest($id);
            $this->json(['ok' => true]);
        } else {
            $this->json(['ok' => false], 400);
        }
    }
}
