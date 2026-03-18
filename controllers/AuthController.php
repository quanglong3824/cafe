<?php
// ============================================================
// AuthController — PIN Login & Redirect
// ============================================================

require_once BASE_PATH . '/models/User.php';

class AuthController extends Controller
{
    /**
     * GET /home — Landing page for iOS Home Screen
     */
    public function landing(): void
    {
        $this->view('layouts/public', [
            'view' => 'home',
            'pageTitle' => 'Aurora Restaurant',
        ]);
    }

    /**
     * GET / — Redirect theo role sau khi đăng nhập
     */
    public function home(): void
    {
        if (!Auth::check()) {
            $this->landing();
            return;
        }

        // Redirect theo role
        match (Auth::role()) {
            ROLE_WAITER => $this->redirect('/tables'),
            ROLE_ADMIN => $this->redirect('/admin/menu'),
            ROLE_IT => $this->redirect('/it/users'),
            default => $this->redirect('/auth/login'),
        };
    }

    /**
     * GET /auth/login — Hiển thị màn hình PIN login
     */
    public function showLogin(): void
    {
        if (Auth::check()) {
            $this->home();
        }

        // Lấy danh sách nhân viên
        $userModel = new User();
        $staff = $userModel->getActiveStaff();

        // Lấy danh sách ca trực
        $db = getDB();
        $shifts = $db->query("SELECT * FROM shifts")->fetchAll();

        $this->view('auth/login', [
            'pageTitle' => 'Đăng nhập',
            'staff' => $staff,
            'shifts' => $shifts,
        ]);
    }

    /**
     * POST /auth/login — Xử lý PIN login
     */
    public function handleLogin(): void
    {
        $username = trim($this->input('username', ''));
        $pin = trim($this->input('pin', ''));
        $shiftId = (int) $this->input('shift_id', 0);

        if (empty($username) || empty($pin)) {
            $_SESSION['login_error'] = 'Vui lòng nhập tên đăng nhập và mã PIN.';
            $this->redirect('/auth/login');
        }

        $userModel = new User();
        $user = $userModel->findByCredentials($username, $pin);

        if (!$user) {
            $_SESSION['login_error'] = 'PIN không đúng. Vui lòng thử lại.';
            $this->redirect('/auth/login');
        }

        // Kiểm tra ca trực (Chỉ bắt buộc với Waiter)
        if ($user['role'] === ROLE_WAITER && $shiftId <= 0) {
            $_SESSION['login_error'] = 'Vui lòng chọn ca trực của bạn.';
            $this->redirect('/auth/login');
        }

        // Lưu thông tin ca trực vào session
        Auth::login($user);
        $_SESSION['user_shift_id'] = $shiftId;

        $this->home();
    }

    /**
     * GET /auth/logout
     */
    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/auth/login');
    }
}
