<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width-width=device-width, initial-scale=1.0">
    <title>404 — Không tìm thấy</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/errors.css">
</head>

<body>
    <div class="error-container">
        <div class="icon icon-error-404"><i class="fas fa-map-location-dot"></i></div>
        <h1 class="error-title-404">404 — Không tìm thấy</h1>
        <p>Trang bạn tìm kiếm không tồn tại.</p>
        <a href="<?= defined('BASE_URL') ? BASE_URL : '/' ?>/" class="btn-home"><i class="fas fa-home"></i> Trang chủ</a>
    </div>
</body>

</html>
