<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="<?= e(APP_NAME) ?>">
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/public/src/logo/favicon.png">
    <link rel="apple-touch-icon" href="<?= BASE_URL ?>/public/src/logo/favicon.png">
    <meta name="theme-color" content="#d4af37">
    <title><?= e($pageTitle ?? 'Aurora Hotel Plaza') ?> — Cafe</title>

    <!-- Google Fonts: Outfit & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('public/css/waiter.css') ?>">
    <link rel="stylesheet" href="<?= asset('public/css/layout/waiter-notify.css') ?>">
    <?php if (isset($pageCSS)): ?>
        <link rel="stylesheet" href="<?= asset('public/css/' . e($pageCSS) . '.css') ?>">
    <?php endif; ?>
    <script>
        const BASE_URL = '<?= BASE_URL ?>';
    </script>
</head>

<body class="waiter-layout">

    <!-- Top Bar -->
    <header class="waiter-topbar" role="banner">
        <div class="topbar-left">
            <div class="topbar-brand">
                <div class="brand-icon">
                    <i class="fas fa-hotel" aria-hidden="true"></i>
                </div>
                <div class="brand-text">
                    <span class="brand-main">AURORA</span>
                    <span class="brand-sub">HOTEL PLAZA</span>
                    <span class="brand-tag">CAFE</span>
                </div>
            </div>
        </div>
        <div class="topbar-center">
            <span class="topbar-page"><?= e($pageTitle ?? '') ?></span>
        </div>
        <div class="topbar-right">
            <div class="topbar-user-pill">
                <div class="user-avatar">
                    <i class="fas fa-user-tie" aria-hidden="true"></i>
                </div>
                <div class="user-info">
                    <span class="user-name"><?= e(Auth::user()['name'] ?? '') ?></span>
                    <span class="user-role"><?= e(roleLabel(Auth::user()['role'] ?? '')) ?></span>
                </div>
            </div>
            <a href="<?= BASE_URL ?>/auth/logout" class="topbar-logout" aria-label="Đăng xuất">
                <i class="fas fa-power-off" aria-hidden="true"></i>
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="waiter-main" id="main-content">

        <!-- Flash Message -->
        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="alert alert-<?= e($_SESSION['flash']['type']) ?>" style="margin: .75rem 1rem 0;"
                data-autohide="3000" role="alert">
                <i class="fas fa-<?= $_SESSION['flash']['type'] === 'success' ? 'check-circle' : 'exclamation-triangle' ?>"
                    aria-hidden="true"></i>
                <?= e($_SESSION['flash']['message']) ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <?php require BASE_PATH . "/views/{$view}.php"; ?>
        
        <div class="waiter-copyright">
            &copy; 2026 LongDev. v<?= APP_VERSION ?>
        </div>
    </main>

    <style>
        .waiter-copyright {
            text-align: center;
            padding: 20px 0 100px;
            font-size: 0.65rem;
            color: #94a3b8;
            opacity: 0.6;
        }
    </style>

    <!-- Bottom Navigation - Floating with Apple Liquid Glass Design -->
    <nav class="waiter-bottomnav" role="navigation" aria-label="Menu chính">
        <a href="<?= BASE_URL ?>/tables" class="bottomnav-item <?= activeClass('/tables') ?>" aria-label="Sơ đồ bàn">
            <span class="liquid-ring"></span>
            <i class="fas fa-table-cells-large" aria-hidden="true"></i>
            <span>Bàn</span>
        </a>
        <a href="<?= BASE_URL ?>/menu" class="bottomnav-item <?= activeClass('/menu') ?>" aria-label="Menu">
            <span class="liquid-ring"></span>
            <i class="fas fa-book-open" aria-hidden="true"></i>
            <span>Menu</span>
        </a>
        <a href="<?= BASE_URL ?>/notifications" class="bottomnav-item <?= activeClass('/notifications') ?>" aria-label="Thông báo">
            <span class="liquid-ring"></span>
            <i class="fas fa-bell" aria-hidden="true"></i>
            <span class="noti-badge" id="waiterNotiBadge" style="display:none">0</span>
            <span>Thông báo</span>
        </a>
        <a href="<?= BASE_URL ?>/orders" class="bottomnav-item <?= activeClass('/orders') ?>" aria-label="Order">
            <span class="liquid-ring"></span>
            <i class="fas fa-receipt" aria-hidden="true"></i>
            <span>Order</span>
        </a>
        <a href="<?= BASE_URL ?>/orders/history" class="bottomnav-item <?= activeClass('/orders/history') ?>"
            aria-label="Lịch sử">
            <span class="liquid-ring"></span>
            <i class="fas fa-history" aria-hidden="true"></i>
            <span>Lịch sử</span>
        </a>
    </nav>

    <!-- Chat AI Float Button & UI (Temporarily Hidden) -->
    <?php /*
<a href="javascript:void(0)" onclick="toggleAiChat()" class="ai-float-btn" aria-label="AI Assistant"
...
   </div>
</div>
*/ ?>

    <!-- Layout JS (tải trước nội dung trang) -->
    <script src="<?= asset('public/js/layout/waiter-ai.js') ?>" defer></script>

    <!-- App JS -->
    <script src="<?= asset('public/js/app.js') ?>" defer></script>
    <?php if (isset($pageJS)): ?>
        <script src="<?= asset('public/js/' . e($pageJS) . '.js') ?>" defer></script>
    <?php endif; ?>
</body>

</html>
