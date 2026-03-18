<?php
// ============================================================
// MenuController — Waiter: View Digital Menu
// ============================================================

require_once BASE_PATH . '/models/MenuItem.php';
require_once BASE_PATH . '/models/MenuCategory.php';
require_once BASE_PATH . '/models/MenuSet.php';

class MenuController extends Controller
{
    /** GET /menu — Xem menu (phục vụ & khách hàng) */
    public function index(): void
    {
        $tableIdFromUrl = (int) $this->input('table_id');
        $menuType = $this->input('type', 'asia');

        // Nếu URL không có table_id, xóa session cũ để nhân viên chọn lại bàn mới
        if ($tableIdFromUrl <= 0 && Auth::isLoggedIn()) {
            unset($_SESSION['customer_table_id']);
        }

        // LOGIC BẢO MẬT & THÔNG BÁO
        if ($tableIdFromUrl > 0) {
            // Trường hợp khách quét QR
            $_SESSION['customer_table_id'] = $tableIdFromUrl;
            
            // Gửi thông báo cho Waiter: Khách vừa vào bàn
            if (!isset($_SESSION['qr_scanned_notified'])) {
                require_once BASE_PATH . '/models/Support.php';
                $supportModel = new Support();
                $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
                // Tạo thông báo loại 'scan_qr'
                $supportModel->createRequest($tableIdFromUrl, 'scan_qr');
                $_SESSION['qr_scanned_notified'] = true;
            }
        } else if (!isset($_SESSION['customer_table_id'])) {
            // Không có table_id và cũng không có trong session -> Phải là nhân viên
            Auth::requireRole(ROLE_WAITER, ROLE_ADMIN, ROLE_IT);
        }

        $itemModel = new MenuItem();
        $categoryModel = new MenuCategory();
        $setModel = new MenuSet();

        // Lấy categories theo menu type
        // Nếu là tab 'sets', chúng ta không cần lấy categories từ menu_items
        $categories = ($menuType === 'sets') ? [] : $categoryModel->getActiveByType($menuType);
        $grouped = ($menuType === 'sets') ? [] : $itemModel->getGroupedByCategory($menuType);

        // Lấy sets nếu là tab sets
        $sets = [];
        if ($menuType === 'sets') {
            $sets = $setModel->getActive();
            foreach ($sets as &$set) {
                $set['items'] = $setModel->getSetItems($set['id']);
            }
        }

        // Ưu tiên lấy table_id từ session khách nếu có
        $tableId = $tableIdFromUrl ?: ($_SESSION['customer_table_id'] ?? 0);
        $orderId = (int) ($this->input('order_id') ?? 0);

        require_once BASE_PATH . '/models/Order.php';
        require_once BASE_PATH . '/models/Table.php';
        $tableModel = new Table();
        $orderModel = new Order();
        $allTables = $tableModel->getAll();

        // LOGIC TỰ ĐỘNG CHO KHÁCH: Nếu là khách (không có orderId nhưng có tableId)
        if ($tableId > 0 && $orderId === 0) {
            // Xem bàn này có order nào đang 'open' không
            $existingOrder = $orderModel->findOpenOrderByTable($tableId);
            if ($existingOrder) {
                $orderId = (int) $existingOrder['id'];
            } else if (!Auth::isLoggedIn()) {
                // Nếu chưa có và là khách truy cập -> Tự động mở bàn/tạo order nháp
                $tableModel->open($tableId);
                $orderId = $orderModel->create($tableId, null, 1);
            }
        }

        $orderItems = [];
        $orderTotal = 0;
        $order = null;

        if ($orderId > 0) {
            $order = $orderModel->findById($orderId);
            $orderItems = $orderModel->getItems($orderId);
            $totalInfo = $orderModel->getTotal($orderId);
            $orderTotal = is_array($totalInfo) ? ($totalInfo['total'] ?? 0) : $totalInfo;
        }

        // Lấy danh sách menu types thực tế từ categories
        $distinctTypes = $this->db->findAll("SELECT DISTINCT menu_type FROM menu_categories WHERE is_active = 1");
        $menuTypes = [];
        $typeIcons = [
            'asia' => 'fa-bowl-rice',
            'europe' => 'fa-bread-slice',
            'alacarte' => 'fa-utensils',
            'sets' => 'fa-boxes-stacked',
            'other' => 'fa-glass-water',
            'set' => 'fa-boxes-stacked'
        ];
        $typeLabels = [
            'asia' => 'Món Á',
            'europe' => 'Món Âu',
            'alacarte' => 'Ala Carte',
            'sets' => 'Set & Combo',
            'set' => 'Set & Combo',
            'other' => 'Đồ uống / Khác'
        ];

        foreach ($distinctTypes as $dt) {
            $t = $dt['menu_type'];
            $menuTypes[] = [
                'key' => $t,
                'label' => $typeLabels[$t] ?? ucfirst($t),
                'icon' => $typeIcons[$t] ?? 'fa-utensils'
            ];
        }
        
        // Luôn thêm tab 'sets' nếu chưa có trong categories (vì sets lấy từ bảng riêng)
        $hasSets = false;
        foreach ($menuTypes as $mt) if ($mt['key'] === 'sets' || $mt['key'] === 'set') $hasSets = true;
        if (!$hasSets) {
            array_unshift($menuTypes, ['key' => 'sets', 'label' => 'Set & Combo', 'icon' => 'fa-boxes-stacked']);
        }

        // Chọn layout: Nhân viên (waiter) hoặc Khách hàng (public)
        $layout = Auth::isLoggedIn() ? 'layouts/waiter' : 'layouts/public';

        $this->view($layout, [
            'view' => 'menu/index',
            'pageTitle' => $tableId > 0 ? "Bàn {$tableId} - Gọi Món" : 'Menu',
            'categories' => $categories,
            'grouped' => $grouped,
            'sets' => $sets,
            'currentType' => $menuType,
            'menuTypes' => $menuTypes,
            'tableId' => $tableId,
            'orderId' => $orderId,
            'order' => $order,
            'orderItems' => $orderItems,
            'orderTotal' => $orderTotal,
            'tables' => $allTables,
            'tablesByArea' => $tableModel->getAllGroupedByArea(),
            'isCustomer' => !Auth::isLoggedIn(),
            'tableModel' => $tableModel,
        ]);
    }
}
