<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#d4af37">
    <title><?= e($pageTitle ?? 'Admin') ?> — Aurora Cafe</title>

    <!-- App Icons & iOS Web App Meta -->
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/public/src/logo/favicon.png">
    <link rel="apple-touch-icon" href="<?= BASE_URL ?>/public/src/logo/favicon.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="<?= e(APP_NAME) ?>">

    <!-- Google Fonts: Outfit & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- QRCode JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <!-- App CSS -->
    <link rel="stylesheet" href="<?= asset('public/css/admin.css') ?>">
    <script>const BASE_URL = '<?= BASE_URL ?>';</script>
    <?php if (isset($pageCSS)): ?>
        <link rel="stylesheet" href="<?= asset('public/css/' . e($pageCSS) . '.css') ?>">
    <?php endif; ?>
</head>

<body class="admin-layout">

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="sidebar">

        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-utensils"></i>
                <div>
                    <h2>Aurora</h2>
                    <p>Cafe Manager</p>
                </div>
            </div>
        </div>

        <!-- Sidebar Nav -->
        <nav class="sidebar-nav">

            <?php if (Auth::isAdmin()): ?>
                <div class="nav-section">
                    <div class="nav-section-title">Nhân sự & Ca trực</div>
                    <a href="<?= BASE_URL ?>/admin/shifts" class="nav-item <?= activeClass('/admin/shifts') ?>">
                        <i class="fas fa-user-clock"></i>
                        <span>Phân ca & Nhân sự</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Hệ thống</div>
                    <a href="<?= BASE_URL ?>/admin/menu" class="nav-item <?= activeClass('/admin/menu') ?>">
                        <i class="fas fa-utensils"></i>
                        <span>Quản lý Món</span>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/menu/sets" class="nav-item <?= activeClass('/admin/menu/sets') ?>"
                        style="padding-left: 2.75rem; font-size: 0.9rem;">
                        <i class="fas fa-layer-group"></i>
                        <span>Set & Combo</span>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/categories" class="nav-item <?= activeClass('/admin/categories') ?>">
                        <i class="fas fa-tags"></i>
                        <span>Danh Mục</span>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/tables" class="nav-item <?= activeClass('/admin/tables') ?>">
                        <i class="fas fa-table-cells-large"></i>
                        <span>Quản lý Bàn</span>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/qr-codes" class="nav-item <?= activeClass('/admin/qr-codes') ?>">
                        <i class="fas fa-qrcode"></i>
                        <span>Quản lý QR</span>
                    </a>
                    <a href="<?= BASE_URL ?>/it/database" class="nav-item <?= activeClass('/it/database') ?>">
                        <i class="fas fa-database"></i>
                        <span>Dữ liệu (Backup)</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Giám sát</div>
                    <a href="<?= BASE_URL ?>/admin/realtime" class="nav-item <?= activeClass('/admin/realtime') ?>">
                        <i class="fas fa-satellite-dish" style="color:#10b981"></i>
                        <span>Thời gian thực</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Báo cáo</div>
                    <a href="<?= BASE_URL ?>/admin/reports" class="nav-item <?= activeClass('/admin/reports') ?>">
                        <i class="fas fa-chart-bar"></i>
                        <span>Thống kê</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">AI Trợ lý</div>
                    <a href="<?= BASE_URL ?>/admin/ai" class="nav-item <?= activeClass('/admin/ai') ?>">
                        <i class="fas fa-robot" style="color:var(--gold)"></i>
                        <span>AI Assistant</span>
                    </a>
                </div>
            <?php endif; ?>

            <?php if (Auth::isIT()): ?>
                <div class="nav-section">
                    <div class="nav-section-title">Quản trị IT</div>
                    <a href="<?= BASE_URL ?>/it/users" class="nav-item <?= activeClass('/it/users') ?>">
                        <i class="fas fa-users"></i>
                        <span>Quản lý User</span>
                    </a>
                </div>
            <?php endif; ?>

            <div class="nav-section">
                <div class="nav-section-title">Tài khoản</div>
                <a href="<?= BASE_URL ?>/auth/logout" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Đăng xuất</span>
                </a>
            </div>

        </nav>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <i class="fas fa-user-circle"></i>
                <div>
                    <strong><?= e(Auth::user()['name'] ?? '') ?></strong>
                    <span><?= e(roleLabel(Auth::user()['role'] ?? '')) ?></span>
                </div>
            </div>
            <div class="copyright-info">
                <p>&copy; 2026 LongDev. v<?= APP_VERSION ?></p>
            </div>
        </div>

    </aside>

    <style>
        .copyright-info {
            padding: 10px 1.5rem;
            font-size: 0.65rem;
            color: rgba(255,255,255,0.3);
            border-top: 1px solid rgba(255,255,255,0.05);
            text-align: center;
        }
    </style>

    <!-- Main Content -->
    <div class="admin-body">

        <!-- Page Header -->
        <div class="admin-topbar">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="admin-topbar-title">
                <h1><?= e($pageTitle ?? '') ?></h1>
                <?php if (isset($pageSubtitle)): ?>
                    <p><?= e($pageSubtitle) ?></p>
                <?php endif; ?>
            </div>

            <!-- Notification Area -->
            <div class="notification-area" id="notificationArea">
                <button class="notification-bell" id="notificationBell">
                    <i class="fas fa-bell"></i>
                    <span class="notification-count" id="notificationCount"></span>
                </button>
                <div class="notification-panel" id="notificationPanel">
                    <div class="notification-panel-header">
                        <span>Thông báo</span>
                        <button class="btn-ghost small" id="markAllAsReadBtn">Đánh dấu đã đọc</button>
                    </div>
                    <div class="notification-list" id="notificationList">
                        <!-- Notifications will be injected here by JavaScript -->
                        <div class="notification-item empty">Chưa có thông báo mới.</div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Content -->
        <main class="admin-main">
            <?php
            // Flash message
            if (!empty($_SESSION['flash'])):
                $fType = $_SESSION['flash']['type'];
                $fIcon = match ($fType) {
                    'success' => 'check-circle',
                    'warning' => 'exclamation-triangle',
                    'danger' => 'times-circle',
                    default => 'info-circle',
                };
                ?>
                <div class="alert alert-<?= e($fType) ?>" data-autohide="4000" role="alert">
                    <i class="fas fa-<?= $fIcon ?>" aria-hidden="true"></i>
                    <?= e($_SESSION['flash']['message']) ?>
                </div>
                <?php unset($_SESSION['flash']); endif; ?>

            <?php require BASE_PATH . "/views/{$view}.php"; ?>
        </main>

    </div>

    <!-- App JS -->
    <script src="<?= asset('public/js/app.js') ?>" defer></script>
    <?php if (isset($pageJS)): ?>
        <script src="<?= asset('public/js/' . e($pageJS) . '.js') ?>" defer></script>
    <?php endif; ?>

</body>

</html>