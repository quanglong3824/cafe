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
        <a href="<?= BASE_URL ?>/qr/menu?table_id=<?= $order['table_id'] ?>&token=<?= $_SESSION['qr_token'] ?? '' ?>" class="btn-gold">
            <i class="fas fa-utensils"></i> <?= __('order_more') ?>
        </a>
        <a href="<?= BASE_URL ?>/qr/menu?table_id=<?= $order['table_id'] ?>&token=<?= $_SESSION['qr_token'] ?? '' ?>" class="btn-outline">
            <i class="fas fa-arrow-left"></i> QUAY VỀ TRANG ORDER
        </a>
    </div>

    <!-- Payment Success Backdrop -->
    <div id="paymentSuccessOverlay" class="payment-success-overlay" style="display:none;">
        <div class="success-content text-center">
            <div class="success-icon">
                <i class="fas fa-heart"></i>
            </div>
            <h2>Cảm ơn Quý khách!</h2>
            <p>Hóa đơn của Quý khách đã được thanh toán thành công.</p>
            <p class="small text-muted">Hẹn gặp lại Quý khách lần sau!</p>
            <div class="mt-4">
                <a href="<?= BASE_URL ?>/qr/menu?table_id=<?= $order['table_id'] ?>&token=<?= $_SESSION['qr_token'] ?? '' ?>" class="btn-gold">
                    <i class="fas fa-home me-2"></i> TIẾP TỤC ĐẶT MÓN
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.payment-success-overlay {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px);
    z-index: 9999; display: flex; align-items: center; justify-content: center;
    padding: 30px; animation: fadeIn 0.5s ease forwards;
}
.success-content { max-width: 400px; width: 100%; }
.success-icon {
    width: 100px; height: 100px; background: #fff5f5; color: #f87171;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 3.5rem; margin: 0 auto 20px; box-shadow: 0 10px 25px rgba(248, 113, 113, 0.2);
    animation: heartBeat 1.5s infinite;
}
@keyframes heartBeat {
    0% { transform: scale(1); }
    14% { transform: scale(1.3); }
    28% { transform: scale(1); }
    42% { transform: scale(1.3); }
    70% { transform: scale(1); }
}
</style>

<script>
    // Real-time Order Status Polling for Customers
    let lastItemsHash = '<?= md5(implode('|', array_map(fn($it) => $it['id'] . "-" . $it['status'] . "-" . $it['quantity'], $items))) ?>';

    const pollStatus = () => {
        // Add cache busting param
        const url = `<?= BASE_URL ?>/qr/order/check-status?table_id=<?= $order['table_id'] ?>&t=${new Date().getTime()}`;
        
        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.ok) {
                    // Check for general order close
                    if (data.status === 'closed') {
                        document.getElementById('paymentSuccessOverlay').style.display = 'flex';
                        return; // Stop polling
                    }
                    
                    // Check for individual item status changes (confirmed, cooking, etc)
                    if (data.items_hash && data.items_hash !== lastItemsHash) {
                        console.log('Order content changed, reloading view...');
                        location.reload();
                        return;
                    }
                }
                
                // Keep polling every 3 seconds for faster response
                setTimeout(pollStatus, 3000);
            })
            .catch(err => {
                console.error('Status poll error:', err);
                setTimeout(pollStatus, 3000);
            });
    };

    // Initial Start
    setTimeout(pollStatus, 3000);
</script>
