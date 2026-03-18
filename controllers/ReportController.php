<?php
// ReportController
require_once BASE_PATH . '/models/Order.php';
require_once BASE_PATH . '/models/MenuItem.php';

class ReportController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $orderModel = new Order();
        $itemModel = new MenuItem();

        $today = date('Y-m-d');
        $from = $this->input('from', date('Y-m-01'));  // Đầu tháng
        $to = $this->input('to', $today);

        $stats = $orderModel->getStatsByDateRange($from, $to);
        $daily = $orderModel->getDailyRevenue($from, $to);
        $topItems = $itemModel->getTopItems(10, $from, $to);
        $todayOrders = $orderModel->getByDate($today);

        $this->view('layouts/admin', [
            'view' => 'reports/index',
            'pageTitle' => 'Thống kê',
            'pageSubtitle' => "Từ {$from} đến {$to}",
            'stats' => $stats,
            'daily' => $daily,
            'topItems' => $topItems,
            'todayOrders' => $todayOrders,
            'from' => $from,
            'to' => $to,
        ]);
    }
}
