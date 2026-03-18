<?php // views/orders/status.php — Order Status for Customers ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/orders/status.css?v=<?= time() ?>">

<div class="status-container">
    <div class="status-header">
        <div class="status-icon success">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1><?= __('order_sent') ?></h1>
        <p><?= __('wait_for_waiter') ?></p>
    </div>

    <div class="order-summary-card">
        <div class="card-header">
            <h3><?= __('order_details_title') ?></h3>
            <span class="order-id"><?= __('order_id') ?><?= e($order['id']) ?></span>
        </div>
        <div class="card-body">
            <div class="items-list">
                <?php $total = 0; ?>
                <?php foreach ($items as $it): ?>
                    <div class="status-item-row">
                        <div class="item-info">
                            <span class="item-qty">x<?= $it['quantity'] ?></span>
                            <span class="item-name"><?= e(getLang() === 'en' && !empty($it['name_en']) ? $it['name_en'] : $it['item_name']) ?></span>
                            <div class="item-status <?= e($it['status']) ?>">
                                <?php 
                                    $statusMap = [
                                        'pending' => __('status_pending'),
                                        'confirmed' => __('status_confirmed'),
                                        'cooking' => __('status_cooking'),
                                        'served' => __('status_served'),
                                        'cancelled' => __('status_cancelled')
                                    ];
                                    echo $statusMap[$it['status']] ?? $it['status'];
                                ?>
                            </div>
                        </div>
                        <div class="item-price"><?= formatPrice($it['item_price'] * $it['quantity']) ?></div>
                    </div>
                    <?php if ($it['status'] !== 'cancelled') $total += $it['item_price'] * $it['quantity']; ?>
                <?php endforeach; ?>
            </div>
            <div class="summary-footer">
                <div class="total-row">
                    <span><?= __('total') ?></span>
                    <strong><?= formatPrice($total) ?></strong>
                </div>
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="<?= BASE_URL ?>/qr/menu?table_id=<?= $order['table_id'] ?>&token=<?= $_SESSION['qr_token'] ?? '' ?>" class="btn-outline">
            <i class="fas fa-plus"></i> <?= __('order_more') ?>
        </a>
        <button class="btn-gold" onclick="requestSupport(<?= $order['table_id'] ?>, 'payment')">
            <i class="fas fa-file-invoice-dollar"></i> <?= __('request_payment') ?>
        </button>
    </div>
</div>
