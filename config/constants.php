<?php
// ============================================================
// App Constants
// Aurora Restaurant — Digital Menu & Order System
// ============================================================

// App info
define('APP_NAME', 'Aurora Cafe');
define('APP_VERSION', '2.0.0 (Pre-release)');
define('APP_LANG', 'vi');

// Paths
define('BASE_PATH', dirname(__DIR__));

// Tự động xác định BASE_URL (URL tuyệt đối bao gồm cả protocol và domain)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$basePath = ($scriptDir === '/' || $scriptDir === '\\') ? '' : rtrim($scriptDir, '/');

// BASE_URL cho các đường dẫn (links, redirects)
define('BASE_URL', $protocol . $host . $basePath);
// ROUTE_BASE_PATH cho việc định tuyến (chỉ lấy phần path)
define('ROUTE_BASE_PATH', $basePath);

define('UPLOAD_PATH', BASE_PATH . '/public/uploads/');
define('UPLOAD_URL', BASE_URL . '/public/uploads/');
define('BACKUP_PATH', BASE_PATH . '/backups/');

// Session
define('SESSION_NAME', 'aurora_restaurant_session');
define('SESSION_LIFETIME', 60 * 60 * 8); // 8 giờ

// Roles
define('ROLE_WAITER', 'waiter');
define('ROLE_ADMIN', 'admin');
define('ROLE_IT', 'it');

// Upload
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp']);

// Table status
define('TABLE_AVAILABLE', 'available');
define('TABLE_OCCUPIED', 'occupied');

// Order status
define('ORDER_OPEN', 'open');
define('ORDER_CLOSED', 'closed');

// Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Toạ độ nhà hàng (Latitude, Longitude)
define('RESTAURANT_LAT', 10.957350753989619);
define('RESTAURANT_LNG', 106.84462256494264);
define('MAX_ORDER_DISTANCE', 500); // Khoảng cách tối đa (mét) để được xem menu

