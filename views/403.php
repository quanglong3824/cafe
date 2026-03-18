<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Không có quyền</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/errors.css">
</head>

<body>
    <div class="error-container">
        <div class="icon icon-error-403"><i class="fas fa-shield-alt"></i></div>
        <h1 class="error-title-403">403 — Không có quyền</h1>
        <p>Bạn không có quyền truy cập trang này.</p>
        <a href="<?= defined('BASE_URL') ? BASE_URL : '/' ?>/" class="btn-home"><i class="fas fa-home"></i> Trang chủ</a>
    </div>
</body>

</html>
