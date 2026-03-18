<?php
// ============================================================
// AdminTableController — Full CRUD + Toggle Active
// ============================================================

require_once BASE_PATH . '/models/Table.php';

class AdminTableController extends Controller
{
    private Table $model;

    public function __construct()
    {
        $this->model = new Table();
    }

    /** GET /admin/tables */
    public function index(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        // One-time migration for missing tables and columns
        try {
            // Fix order_notifications
            $this->model->execute("ALTER TABLE order_notifications MODIFY order_id int(10) unsigned NULL");

            // Fix orders: allow waiter_id to be NULL for QR orders
            $this->model->execute("ALTER TABLE orders MODIFY waiter_id int(10) unsigned NULL");
            
            // Create customer_sessions if not exists
            $this->model->execute("CREATE TABLE IF NOT EXISTS `customer_sessions` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `session_id` varchar(255) NOT NULL,
                `table_id` int(10) unsigned NOT NULL,
                `order_id` int(10) unsigned DEFAULT NULL,
                `ip_address` varchar(45) DEFAULT NULL,
                `user_agent` text DEFAULT NULL,
                `is_active` tinyint(1) NOT NULL DEFAULT 1,
                `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                `expires_at` timestamp NULL DEFAULT NULL,
                `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`),
                UNIQUE KEY `idx_session_id` (`session_id`),
                KEY `idx_table_active` (`table_id`,`is_active`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        } catch (\Throwable $e) {}

        // Tự động đồng bộ trạng thái bàn (Sửa lỗi bàn bị kẹt 'Có khách' dù đã xong)
        $this->model->syncStatuses();

        // Auto-cleanup invalid QR tokens (historical garbage data)
        require_once BASE_PATH . '/models/QrTable.php';
        $qrModel = new QrTable();
        $qrModel->cleanupInvalidTokens();

        $tables = $this->model->getAllForAdmin();
        $this->view('layouts/admin', [
            'view' => 'admin/tables/index',
            'pageTitle' => 'Quản lý Bàn',
            'pageSubtitle' => count($tables) . ' bàn',
            'tables' => $tables,
            'editItem' => null,
        ]);
    }

    /** POST /admin/tables/store */
    public function store(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $name = trim((string) $this->input('name', ''));
        if (!$name) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Tên bàn không được để trống.'];
            $this->redirect('/admin/tables');
        }

        $tableId = $this->model->create([
            'name' => $name,
            'area' => trim((string) $this->input('area', '')) ?: null,
            'capacity' => max(1, (int) $this->input('capacity', 4)),
            'sort_order' => (int) $this->input('sort_order', 0),
        ]);

        // Auto-generate QR code for the new table
        require_once BASE_PATH . '/models/QrTable.php';
        $qrModel = new QrTable();
        $token = bin2hex(random_bytes(16));
        $qrModel->generate($tableId, $token);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã thêm bàn và tạo mã QR!'];
        $this->redirect('/admin/tables');
    }

    /** GET /admin/tables/edit?id= */
    public function edit(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $id = (int) $this->input('id');
        $item = $this->model->findById($id);
        if (!$item) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Không tìm thấy bàn.'];
            $this->redirect('/admin/tables');
        }

        $tables = $this->model->getAllForAdmin();
        $this->view('layouts/admin', [
            'view' => 'admin/tables/index',
            'pageTitle' => 'Quản lý Bàn',
            'pageSubtitle' => count($tables) . ' bàn',
            'tables' => $tables,
            'editItem' => $item,
        ]);
    }

    /** POST /admin/tables/update */
    public function update(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $id = (int) $this->input('id');
        $name = trim((string) $this->input('name', ''));
        if (!$name) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Tên bàn không được để trống.'];
            $this->redirect('/admin/tables');
        }

        $this->model->update($id, [
            'name' => $name,
            'area' => trim((string) $this->input('area', '')) ?: null,
            'capacity' => max(1, (int) $this->input('capacity', 4)),
            'sort_order' => (int) $this->input('sort_order', 0),
            'is_active' => (int) $this->input('is_active', 1),
        ]);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã cập nhật bàn!'];
        $this->redirect('/admin/tables');
    }

    /** POST /admin/tables/delete */
    public function delete(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $id = (int) $this->input('id');
        $ok = $this->model->delete($id);

        if (!$ok) {
            $_SESSION['flash'] = ['type' => 'warning', 'message' => 'Bàn đang có khách, không thể xóa.'];
        } else {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã xóa bàn.'];
        }
        $this->redirect('/admin/tables');
    }
}
