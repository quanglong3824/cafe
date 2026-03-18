<?php
// ============================================================
// AdminRealtimeController — Real-time Monitoring
// ============================================================

require_once BASE_PATH . '/models/Order.php';
require_once BASE_PATH . '/models/Table.php';

class AdminRealtimeController extends Controller
{
    private Order $orderModel;
    private Table $tableModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->tableModel = new Table();
    }

    /**
     * GET /admin/realtime — Dashboard theo thời gian thực
     */
    public function index(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        // Đồng bộ trạng thái bàn
        $this->tableModel->syncStatuses();

        // Lấy tất cả bàn đang bận và chi tiết order
        $rawOrders = $this->orderModel->getRealtimeOrders();
        $orders = [];

        foreach ($rawOrders as $order) {
            $order['items'] = $this->orderModel->getItems($order['id']);
            $order['full_name'] = $this->tableModel->getFullDisplayName($order['table_id']);
            $order['rounds'] = $this->calculateOrderRounds($order['items']);
            $orders[] = $order;
        }

        $this->view('layouts/admin', [
            'view' => 'admin/realtime/index',
            'pageTitle' => 'Quản lý Thời gian thực',
            'pageSubtitle' => 'Theo dõi tình trạng các bàn đang phục vụ',
            'orders' => $orders,
            'counts' => $this->tableModel->countByStatus(),
        ]);
    }

    /**
     * AJAX để update thông tin không cần load lại trang
     */
    public function data(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        // Đồng bộ trạng thái bàn
        $this->tableModel->syncStatuses();

        $rawOrders = $this->orderModel->getRealtimeOrders();
        $orders = [];

        foreach ($rawOrders as $order) {
            $order['items'] = $this->orderModel->getItems($order['id']);
            $order['rounds'] = $this->calculateOrderRounds($order['items']);
            $order['full_name'] = $this->tableModel->getFullDisplayName($order['table_id']);
            $order['opened_at_fmt'] = date('H:i', strtotime($order['opened_at']));
            $order['closed_at_fmt'] = $order['closed_at'] ? date('H:i', strtotime($order['closed_at'])) : null;
            $order['total_fmt'] = formatPrice($order['total']);
            
            // Format items prices
            foreach ($order['items'] as &$it) {
                $it['item_price_fmt'] = formatPrice($it['item_price']);
                $it['subtotal_fmt'] = formatPrice($it['item_price'] * $it['quantity']);
            }
            $orders[] = $order;
        }
        
        $this->json([
            'ok' => true, 
            'data' => $orders,
            'counts' => $this->tableModel->countByStatus()
        ]);
    }

    /**
     * POST /admin/realtime/dismiss — Ẩn một card (lưu vào Database)
     */
    public function dismiss(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);
        $orderId = (int) $this->input('order_id');
        if ($orderId > 0) {
            $this->orderModel->dismissFromRealtime($orderId);
        }
        $this->json(['ok' => true]);
    }

    private function calculateOrderRounds(array $items): int
    {
        if (empty($items))
            return 0;

        $rounds = 0;
        $lastTime = null;

        // Sắp xếp items theo thời gian tạo
        usort($items, function ($a, $b) {
            return strtotime($a['created_at']) - strtotime($b['created_at']);
        });

        foreach ($items as $it) {
            $currentTime = strtotime($it['created_at']);
            // Nếu cách nhau hơn 5 phút thì tính là đợt mới
            if ($lastTime === null || ($currentTime - $lastTime) > 300) {
                $rounds++;
            }
            $lastTime = $currentTime;
        }

        return $rounds;
    }
}
