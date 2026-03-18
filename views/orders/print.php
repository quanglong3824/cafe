<?php // views/orders/print.php ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn <?= e($tableDisplayName) ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/orders/print.css">
</head>

<body onload="window.print();">

    <div class="header text-center mb-2">
        <h1 class="font-bold">AURORA RESTAURANT</h1>
        <p>123 Đường XYZ, Quận 1, TP. HCM</p>
        <p>Tel: 0123.456.789</p>
    </div>

    <div class="divider"></div>

    <div class="text-center font-bold mb-2">PHIẾU THANH TOÁN</div>

    <div class="meta-info mb-1">
        <span>Bàn: <strong><?= e($tableDisplayName) ?></strong></span>
        <span>Số khách: <?= $order['guest_count'] ?></span>
    </div>
    <div class="meta-info mb-1">
        <span>Phục vụ: <?= e($order['waiter_name'] ?? 'N/A') ?></span>
        <span>Giờ mở: <?= date('H:i', strtotime($order['opened_at'])) ?></span>
    </div>
    <div class="meta-info">
        <span>Ngày: <?= date('d/m/Y') ?></span>
        <span>Giờ in: <?= date('H:i') ?></span>
    </div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th>Tên món</th>
                <th class="col-qty">SL</th>
                <th class="col-price">Đơn giá</th>
                <th class="col-total">T.Tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= e($item['item_name']) ?></td>
                    <td class="col-qty"><?= $item['quantity'] ?></td>
                    <td class="col-price"><?= number_format($item['item_price'], 0, ',', '.') ?></td>
                    <td class="col-total"><?= number_format($item['item_price'] * $item['quantity'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="divider"></div>

    <div class="total-row">
        <span>TỔNG CỘNG:</span>
        <span><?= formatPrice($total) ?></span>
    </div>

    <?php
    // Nếu đơn đã đóng HOẶC có truyền phương thức thanh toán từ URL (thao tác in khi đóng bàn) thì mới coi là đã thanh toán
    $isActuallyPaid = ($order['status'] === 'closed' || !empty($_GET['payment_method']));

    if ($isActuallyPaid && !empty($order['payment_method'])): ?>
        <div class="payment-good">
            ĐÃ THANH TOÁN
        </div>
        <div class="payment-status">
            <span>Phương thức:</span>
            <span class="font-bold">
                <?php
                switch ($order['payment_method']) {
                    case 'cash':
                        echo 'Tiền mặt';
                        break;
                    case 'transfer':
                        echo 'Chuyển khoản';
                        break;
                    case 'card':
                        echo 'Thẻ ngân hàng';
                        break;
                    default:
                        echo e($order['payment_method']);
                }
                ?>
            </span>
        </div>
    <?php else: ?>
        <div class="payment-pending">
            CHƯA THANH TOÁN
        </div>
        <div class="payment-note">
            (Đây là phiếu tạm tính)
        </div>
    <?php endif; ?>

    <div class="divider"></div>

    <div class="footer">
        <p>Cảm ơn quý khách và hẹn gặp lại!</p>
        <p>Powered by Aurora System</p>
    </div>

</body>

</html>
