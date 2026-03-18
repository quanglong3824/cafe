<!DOCTYPE html>
<html lang="<?= getLang() ?>" translate="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="google" content="notranslate">
    <meta name="theme-color" content="#c5a059">
    <title><?= e($pageTitle ?? 'Menu') ?> — Aurora Hotel Plaza</title>

    <!-- App Icons & iOS Web App Meta -->
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/public/src/logo/favicon.png">
    <link rel="apple-touch-icon" href="<?= BASE_URL ?>/public/src/logo/favicon.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="<?= e(APP_NAME) ?>">

    <!-- Google Fonts: Outfit & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Global JS Config -->
    <script>
        const BASE_URL = '<?= BASE_URL ?>';
        const APP_LANG = '<?= getLang() ?>';
        const TRANSLATIONS = <?= json_encode([
            'authenticating' => __('authenticating'),
            'loc_timeout' => __('loc_timeout'),
            'browser_no_loc' => __('browser_no_loc'),
            'too_far' => __('too_far'),
            'permission_denied' => __('permission_denied'),
            'pos_unavailable' => __('pos_unavailable'),
            'timeout' => __('timeout'),
            'unknown_error' => __('unknown_error'),
            'retry' => __('retry'),
            'added_item' => __('added_item'),
            'cart_empty' => __('cart_empty'),
            'continue_choosing' => __('continue_choosing'),
            'note_label' => __('note_label'),
            'processing' => __('processing'),
            'order_success' => __('order_success'),
            'order_fail' => __('order_fail'),
            'conn_error' => __('conn_error'),
            'call_waiter_confirm' => __('call_waiter_confirm'),
            'payment_confirm' => __('payment_confirm'),
            'request_sent' => __('request_sent'),
            'request_fail' => __('request_fail'),
            'no_desc' => __('no_desc')
        ]) ?>;

        /**
         * Helper to get translation with replacements
         */
        function __(key, replace = {}) {
            let text = TRANSLATIONS[key] || key;
            for (const [s, v] of Object.entries(replace)) {
                text = text.replace(`:${s}`, v);
            }
            return text;
        }
    </script>

    <style>
        :root {
            --gold: #c5a059;
            --gold-dark: #a68341;
            --bg: #f8fafc;
        }
        body { margin: 0; padding: 0; background: var(--bg); font-family: 'Outfit', sans-serif; overflow-x: hidden; }
        .loading-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: #ffffff; z-index: 9999; display: flex; align-items: center; justify-content: center;
            transition: opacity 0.5s;
        }
        .loading-spinner {
            width: 50px; height: 50px; border: 3px solid var(--bg);
            border-top: 3px solid var(--gold); border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>

<body>
    <!-- Initial Loading -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Main Content View -->
    <?php require BASE_PATH . "/views/{$view}.php"; ?>

    <script>
        // Hide loading when everything is ready
        window.addEventListener('load', () => {
            const overlay = document.getElementById('loadingOverlay');
            overlay.style.opacity = '0';
            setTimeout(() => overlay.remove(), 500);
        });
    </script>
</body>

</html>
