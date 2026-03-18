<?php
// ============================================================
// NotificationController — Aurora Restaurant
// ============================================================

require_once BASE_PATH . '/models/OrderNotification.php';
require_once BASE_PATH . '/models/Support.php';

class NotificationController extends Controller
{
    private OrderNotification $notifModel;
    private Support $supportModel;

    public function __construct()
    {
        // Fix: Auth::requireRole uses variadic args
        Auth::requireRole(ROLE_WAITER, ROLE_ADMIN, ROLE_IT);
        $this->notifModel = new OrderNotification();
        $this->supportModel = new Support();
    }

    /** GET /notifications — Trang trung tâm điều hành */
    public function waiterIndex(): void
    {
        $this->view('layouts/waiter', [
            'view' => 'notifications/waiter',
            'pageTitle' => 'Trung tâm điều hành',
        ]);
    }

    /** API: Poll for notifications */
    public function poll(): void
    {
        try {
            $page = max(1, (int)($this->input('page', 1)));
            $limit = max(1, (int)($this->input('limit', 15)));
            $filter = $this->input('filter', 'all');

            // Lấy danh sách thông báo phân trang
            $notifications = $this->notifModel->getPaged($page, $limit, $filter);
            $totalCount = $this->notifModel->countAll($filter);
            
            // Lấy thêm stats (unread count) để cập nhật badge
            $stats = [
                'unread' => $this->notifModel->countUnread(),
                'payment' => $this->notifModel->countUnreadByType('payment_request'),
                'order' => $this->notifModel->countUnreadByType('new_order'),
                'support' => $this->notifModel->countUnreadByType('support_request'),
            ];

            $this->json([
                'ok' => true,
                'notifications' => $notifications,
                'total_count' => $totalCount,
                'page' => $page,
                'limit' => $limit,
                'stats' => $stats,
                'server_time' => date('Y-m-d H:i:s')
            ]);
        } catch (\Throwable $e) {
            $this->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /** API: Đánh dấu đã đọc/xử lý */
    public function markRead(): void
    {
        $id = (int)($this->input('id', 0));
        $userId = Auth::user()['id'];

        if ($id > 0) {
            $this->notifModel->markAsRead($id, $userId);
        } else {
            $this->notifModel->markAllAsRead($userId);
        }

        $this->json(['ok' => true]);
    }

    /** API: Xử lý nhanh yêu cầu hỗ trợ từ thông báo */
    public function resolveSupport(): void
    {
        $tableId = (int)($this->input('table_id', 0));
        $type = $this->input('type', '');

        if ($tableId > 0) {
            // Đánh dấu hoàn thành trong bảng support_requests nếu có
            $this->supportModel->resolveByTableAndType($tableId, $type);
            $this->json(['ok' => true]);
        } else {
            $this->json(['ok' => false, 'error' => 'Thiếu thông tin bàn'], 400);
        }
    }
}
