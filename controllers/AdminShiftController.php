<?php
// ============================================================
// AdminShiftController — Quản lý Ca trực
// ============================================================

require_once BASE_PATH . '/models/User.php';

class AdminShiftController extends Controller
{
    /** GET /admin/shifts */
    public function index(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);

        $db = getDB();
        $shifts = $db->query("SELECT * FROM shifts ORDER BY start_time ASC")->fetchAll();
        
        $userModel = new User();
        $users = $userModel->getAll();

        // Lấy danh sách phân công hôm nay
        $today = date('Y-m-d');
        $assignments = $db->query(
            "SELECT us.*, u.name as user_name, s.name as shift_name 
             FROM user_shifts us
             JOIN users u ON u.id = us.user_id
             JOIN shifts s ON s.id = us.shift_id
             WHERE us.work_date = ?
             ORDER BY s.start_time ASC, u.name ASC",
            [$today]
        )->fetchAll();

        $this->view('layouts/admin', [
            'view' => 'admin/shifts/index',
            'pageTitle' => 'Quản lý Ca trực',
            'shifts' => $shifts,
            'users' => $users,
            'assignments' => $assignments,
            'today' => $today
        ]);
    }

    /** POST /admin/shifts/store (Thêm Ca) */
    public function store(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);
        
        $name = trim((string) $this->input('name'));
        $startTime = $this->input('start_time');
        $endTime = $this->input('end_time');

        if ($name && $startTime && $endTime) {
            $db = getDB();
            $db->prepare("INSERT INTO shifts (name, start_time, end_time) VALUES (?, ?, ?)")
               ->execute([$name, $startTime, $endTime]);
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã thêm ca trực mới.'];
        }
        $this->redirect('/admin/shifts');
    }

    /** POST /admin/shifts/delete (Xóa Ca) */
    public function delete(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);
        $id = (int) $this->input('id');
        
        $db = getDB();
        $db->prepare("DELETE FROM shifts WHERE id = ?")->execute([$id]);
        
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã xóa ca trực.'];
        $this->redirect('/admin/shifts');
    }

    /** POST /admin/shifts/assign (Phân công nhân viên) */
    public function assign(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);
        
        $userId = (int) $this->input('user_id');
        $shiftId = (int) $this->input('shift_id');
        $date = $this->input('work_date', date('Y-m-d'));

        if ($userId && $shiftId && $date) {
            $db = getDB();
            // Check trùng
            $exists = $db->query("SELECT id FROM user_shifts WHERE user_id = ? AND shift_id = ? AND work_date = ?", [$userId, $shiftId, $date])->fetch();
            if (!$exists) {
                $db->prepare("INSERT INTO user_shifts (user_id, shift_id, work_date) VALUES (?, ?, ?)")
                   ->execute([$userId, $shiftId, $date]);
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã phân công thành công.'];
            } else {
                $_SESSION['flash'] = ['type' => 'warning', 'message' => 'Nhân viên này đã được phân công vào ca này rồi.'];
            }
        }
        $this->redirect('/admin/shifts');
    }
    
    /** POST /admin/shifts/remove_assign (Xóa phân công) */
    public function removeAssign(): void
    {
        Auth::requireRole(ROLE_ADMIN, ROLE_IT);
        $id = (int) $this->input('id');
        
        $db = getDB();
        $db->prepare("DELETE FROM user_shifts WHERE id = ?")->execute([$id]);
        
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã hủy phân công.'];
        $this->redirect('/admin/shifts');
    }
}
