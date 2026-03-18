<?php
// ============================================================
// SettingController — IT: Full User Management
// ============================================================

require_once BASE_PATH . '/models/User.php';

class SettingController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /** GET /it/users */
    public function users(): void
    {
        Auth::requireRole(ROLE_IT);
        $users = $this->userModel->getAll();
        $this->view('layouts/admin', [
            'view' => 'it/users',
            'pageTitle' => 'Quản lý Nhân viên',
            'pageSubtitle' => count($users) . ' tài khoản',
            'users' => $users,
            'editUser' => null,
        ]);
    }

    /** GET /it/users/edit?id= */
    public function editUser(): void
    {
        Auth::requireRole(ROLE_IT);

        $id = (int) $this->input('id');
        $editUser = $this->userModel->findById($id);
        if (!$editUser) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Không tìm thấy nhân viên.'];
            $this->redirect('/it/users');
        }

        $users = $this->userModel->getAll();
        $this->view('layouts/admin', [
            'view' => 'it/users',
            'pageTitle' => 'Quản lý Nhân viên',
            'pageSubtitle' => count($users) . ' tài khoản',
            'users' => $users,
            'editUser' => $editUser,
        ]);
    }

    /** POST /it/users/store */
    public function storeUser(): void
    {
        Auth::requireRole(ROLE_IT);

        $pin = trim((string) $this->input('pin', ''));
        if (strlen($pin) !== 4 || !ctype_digit($pin)) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'PIN phải là đúng 4 chữ số.'];
            $this->redirect('/it/users');
        }

        $name = trim((string) $this->input('name', ''));
        $username = trim((string) $this->input('username', ''));

        if (!$name || !$username) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Họ tên và username không được để trống.'];
            $this->redirect('/it/users');
        }

        $this->userModel->create([
            'name' => $name,
            'username' => $username,
            'pin' => $pin,
            'role' => $this->input('role', ROLE_WAITER),
        ]);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã thêm nhân viên!'];
        $this->redirect('/it/users');
    }

    /** POST /it/users/update */
    public function updateUser(): void
    {
        Auth::requireRole(ROLE_IT);

        $id = (int) $this->input('id');
        $name = trim((string) $this->input('name', ''));
        $username = trim((string) $this->input('username', ''));
        $pin = trim((string) $this->input('pin', ''));

        if (!$name || !$username) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Họ tên và username không được để trống.'];
            $this->redirect('/it/users');
        }
        if ($pin !== '' && (strlen($pin) !== 4 || !ctype_digit($pin))) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'PIN phải là đúng 4 chữ số hoặc để trống để giữ nguyên.'];
            $this->redirect('/it/users');
        }

        // Nếu không nhập PIN mới → giữ nguyên PIN cũ
        $current = $this->userModel->findById($id);
        $this->userModel->update($id, [
            'name' => $name,
            'username' => $username,
            'pin' => $pin !== '' ? $pin : $current['pin'],
            'role' => $this->input('role', ROLE_WAITER),
            'is_active' => (int) $this->input('is_active', 1),
        ]);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã cập nhật nhân viên!'];
        $this->redirect('/it/users');
    }

    /** POST /it/users/delete */
    public function deleteUser(): void
    {
        Auth::requireRole(ROLE_IT);

        $id = (int) $this->input('id');
        if ($id === Auth::user()['id']) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Không thể xóa tài khoản đang đăng nhập.'];
        } else {
            $this->userModel->delete($id);
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã xóa nhân viên.'];
        }
        $this->redirect('/it/users');
    }

    /** GET /it/database */
    public function database(): void
    {
        Auth::requireRole(ROLE_IT, ROLE_ADMIN);

        if (!is_dir(BACKUP_PATH)) {
            mkdir(BACKUP_PATH, 0755, true);
        }

        $files = glob(BACKUP_PATH . '*.sql');
        $backups = [];
        foreach ($files as $file) {
            $backups[] = [
                'name' => basename($file),
                'size' => filesize($file),
                'date' => date('Y-m-d H:i:s', filemtime($file)),
            ];
        }
        // Sắp xếp bản mới nhất lên đầu
        usort($backups, fn($a, $b) => strcmp($b['date'], $a['date']));

        $this->view('layouts/admin', [
            'view' => 'it/database',
            'pageTitle' => 'Cơ sở dữ liệu',
            'pageSubtitle' => 'Quản lý sao lưu và phục hồi hệ thống',
            'backups' => $backups,
        ]);
    }

    /** GET /it/database/backup */
    public function backup(): void
    {
        Auth::requireRole(ROLE_IT, ROLE_ADMIN);

        try {
            $db = getDB();
            $tables = [];
            $result = $db->query('SHOW TABLES');
            while ($row = $result->fetch(PDO::FETCH_NUM)) {
                $tables[] = $row[0];
            }

            $sql = "-- Aurora Restaurant Database Backup\n";
            $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
            $sql .= "SET NAMES utf8mb4;\n";
            $sql .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

            foreach ($tables as $table) {
                $result = $db->query("SHOW CREATE TABLE `$table`")->fetch();
                $sql .= "DROP TABLE IF EXISTS `$table`;\n";
                $sql .= $result['Create Table'] . ";\n\n";

                $result = $db->query("SELECT * FROM `$table` ");
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $sql .= "INSERT INTO `$table` VALUES (";
                    $values = [];
                    foreach ($row as $value) {
                        $values[] = ($value === null) ? "NULL" : $db->quote($value);
                    }
                    $sql .= implode(', ', $values) . ");\n";
                }
                $sql .= "\n";
            }
            $sql .= "SET FOREIGN_KEY_CHECKS = 1;\n";

            if (!is_dir(BACKUP_PATH)) {
                mkdir(BACKUP_PATH, 0755, true);
            }

            $filename = 'backup_' . DB_NAME . '_' . date('Ymd_His') . '.sql';
            file_put_contents(BACKUP_PATH . $filename, $sql);

            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã tạo bản sao lưu: ' . $filename];
            $this->redirect('/it/database');
        } catch (Exception $e) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Lỗi sao lưu: ' . $e->getMessage()];
            $this->redirect('/it/database');
        }
    }

    /** GET /it/database/download?file= */
    public function downloadBackup(): void
    {
        Auth::requireRole(ROLE_IT, ROLE_ADMIN);
        $file = $this->input('file');
        $path = BACKUP_PATH . basename($file);

        if ($file && file_exists($path)) {
            header('Content-Type: application/sql');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            readfile($path);
            exit;
        }
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Không tìm thấy file sao lưu.'];
        $this->redirect('/it/database');
    }

    /** POST /it/database/delete */
    public function deleteBackup(): void
    {
        Auth::requireRole(ROLE_IT, ROLE_ADMIN);
        $file = $this->input('file');
        $path = BACKUP_PATH . basename($file);

        if ($file && file_exists($path)) {
            unlink($path);
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã xóa bản sao lưu.'];
        } else {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Không thể xóa file.'];
        }
        $this->redirect('/it/database');
    }
}
