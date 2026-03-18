<?php // views/orders/paid_bill.php — Paid Bill View for Customers ?>
<div class="paid-bill-wrapper">
    <div class="bill-success-header">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h2 class="playfair">Cảm ơn Quý khách!</h2>
        <p>Hóa đơn của bạn đã được thanh toán hoàn tất.</p>
    </div>

    <div class="bill-details-card">
        <div class="bill-info-header">
            <div class="bill-brand">AURORA RESTAURANT</div>
            <div class="bill-meta">
                <span>Bàn: <strong><?= e($table['name']) ?></strong></span>
                <span>Ngày: <?= date('d/m/Y H:i', strtotime($order['closed_at'])) ?></span>
            </div>
            <div class="bill-id">Mã HĐ: #<?= $order['id'] ?></div>
        </div>

        <div class="bill-items">
            <?php $total = 0; ?>
            <?php foreach ($items as $item): ?>
                <?php 
                    if ($item['status'] === 'cancelled') continue;
                    $itemTotal = $item['item_price'] * $item['quantity'];
                    $total += $itemTotal;
                ?>
                <div class="bill-row">
                    <div class="row-qty"><?= $item['quantity'] ?>x</div>
                    <div class="row-name"><?= e($item['item_name']) ?></div>
                    <div class="row-price"><?= formatPrice($itemTotal) ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="bill-divider"></div>

        <div class="bill-total-section">
            <div class="total-row">
                <span>Tổng cộng</span>
                <span class="total-val"><?= formatPrice($total) ?></span>
            </div>
            <div class="payment-method">
                <i class="fas fa-credit-card"></i> 
                Hình thức: <?= $order['payment_method'] === 'cash' ? 'Tiền mặt' : 'Chuyển khoản' ?>
            </div>
        </div>
    </div>

    <div class="bill-actions">
        <p class="text-muted small mb-4">Màn hình gọi món sẽ được mở lại khi có khách mới vào bàn.</p>
        <button class="btn-gold-outline w-100" onclick="window.location.reload()">
            <i class="fas fa-sync-alt me-2"></i> LÀM MỚI TRANG
        </button>
    </div>
</div>

<style>
    .paid-bill-wrapper { padding: 20px; max-width: 500px; margin: 0 auto; text-align: center; }
    .bill-success-header { margin-bottom: 30px; }
    .success-icon { font-size: 4rem; color: #10b981; margin-bottom: 15px; }
    .bill-success-header h2 { font-size: 1.75rem; color: var(--text-dark); margin-bottom: 5px; }
    .bill-success-header p { color: var(--text-light); }

    .bill-details-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        text-align: left;
        border: 1px solid var(--border);
        margin-bottom: 30px;
    }

    .bill-info-header { text-align: center; margin-bottom: 25px; }
    .bill-brand { font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 800; color: var(--gold-dark); letter-spacing: 2px; }
    .bill-meta { display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--text-light); margin-top: 10px; }
    .bill-id { font-size: 0.75rem; color: var(--text-dim); margin-top: 5px; }

    .bill-items { margin-bottom: 20px; }
    .bill-row { display: flex; gap: 10px; padding: 12px 0; border-bottom: 1px solid #f8fafc; font-size: 0.95rem; }
    .row-qty { color: var(--gold-dark); font-weight: 700; width: 30px; }
    .row-name { flex: 1; color: var(--text-dark); }
    .row-price { font-weight: 600; color: var(--text-dark); }

    .bill-divider { border-top: 2px dashed #e2e8f0; margin: 15px 0; }

    .bill-total-section { padding-top: 5px; }
    .total-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
    .total-row span:first-child { font-size: 1.1rem; font-weight: 700; color: var(--text-dark); }
    .total-val { font-size: 1.4rem; font-weight: 800; color: var(--gold-dark); }
    .payment-method { font-size: 0.8rem; color: var(--text-light); text-align: center; margin-top: 15px; }

    .btn-gold-outline {
        background: transparent;
        border: 2px solid var(--gold);
        color: var(--gold-dark);
        padding: 15px;
        border-radius: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-gold-outline:active { transform: scale(0.98); background: var(--gold-light); }
</style>
