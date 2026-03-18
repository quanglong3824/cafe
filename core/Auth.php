<?php
// ============================================================
// Auth Helper — Aurora Cafe
// Session-based auth + PIN login
// ============================================================

class Auth
{

    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_name(SESSION_NAME);
            session_set_cookie_params(SESSION_LIFETIME);
            session_start();
        }
    }

    public static function login(array $user): void
    {
        self::start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['logged_in'] = true;
        session_regenerate_id(true);
    }

    public static function logout(): void
    {
        self::start();
        session_unset();
        session_destroy();
    }

    public static function check(): bool
    {
        self::start();
        return !empty($_SESSION['logged_in']);
    }

    public static function isLoggedIn(): bool
    {
        return self::check();
    }

    public static function user(): ?array
    {
        if (!self::check())
            return null;
        return [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'],
            'role' => $_SESSION['user_role'],
        ];
    }

    public static function role(): ?string
    {
        return $_SESSION['user_role'] ?? null;
    }

    public static function isWaiter(): bool
    {
        return self::role() === ROLE_WAITER;
    }

    public static function isAdmin(): bool
    {
        return in_array(self::role(), [ROLE_ADMIN, ROLE_IT]);
    }

    public static function isIT(): bool
    {
        return self::role() === ROLE_IT;
    }

    /**
     * Bắt buộc đăng nhập — nếu chưa, redirect về login
     */
    public static function require(): void
    {
        if (!self::check()) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }

    /**
     * Yêu cầu role cụ thể
     */
    public static function requireRole(string ...$roles): void
    {
        self::require();
        if (!in_array(self::role(), $roles)) {
            http_response_code(403);
            require_once BASE_PATH . '/views/403.php';
            exit;
        }
    }
}
