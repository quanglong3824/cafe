<?php // views/reports/index.php ?>

<!-- Date filter -->
<div class="card" style="margin-bottom:1.25rem;">
    <form method="GET" action="<?= BASE_URL ?>/admin/reports" class="filter-bar">
        <div class="form-group">
            <label class="form-label">Từ ngày</label>
            <input type="date" name="from" class="form-control" value="<?= e($from) ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Đến ngày</label>
            <input type="date" name="to" class="form-control" value="<?= e($to) ?>">
        </div>
        <button type="submit" class="btn btn-gold">
            <i class="fas fa-search"></i> Xem
        </button>
    </form>
</div>

<!-- Stats cards -->
<div class="stats-grid" style="margin-bottom:1.5rem;">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-receipt"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= number_format($stats['total_orders'] ?? 0) ?></div>
            <div class="stat-label">Lượt order</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-chair"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= number_format($stats['tables_served'] ?? 0) ?></div>
            <div class="stat-label">Bàn phục vụ</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-coins"></i></div>
        <div class="stat-info">
            <div class="stat-value"><?= formatPrice($stats['revenue'] ?? 0) ?></div>
            <div class="stat-label">Tổng doanh thu</div>
        </div>
    </div>
</div>

<div class="data-grid-2">

    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-trophy"></i> Top Món Được Gọi</h2>
        </div>

        <?php if (empty($topItems)): ?>
            <p style="color:#9ca3af;padding:.5rem 0">Chưa có dữ liệu.</p>
        <?php else: ?>
            <?php foreach ($topItems as $i => $topItem): ?>
                <div class="top-item-row">
                    <div class="rank-badge rank-badge--<?= $i < 3 ? $i+1 : 'rest' ?>">
                        <?= $i + 1 ?>
                    </div>
                    <span style="flex:1;font-size:.875rem;font-weight:500"><?= e($topItem['name']) ?></span>
                    <span class="badge badge-gold"><?= $topItem['total_qty'] ?> phần</span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Today's orders -->
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-calendar-day"></i> Hôm nay (<?= date('d/m') ?>)</h2>
        </div>
        <?php if (empty($todayOrders)): ?>
            <p style="color:#9ca3af;padding:.5rem 0">Hôm nay chưa có order.</p>
        <?php else: ?>
            <div style="max-height:340px;overflow-y:auto;">
                <table>
                    <thead>
                        <tr><th>Bàn</th><th>Phục vụ</th><th>Giờ mở</th><th>Tổng</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($todayOrders as $o): ?>
                            <tr>
                                <td><?= e($o['table_name']) ?></td>
                                <td><?= e($o['waiter_name']) ?></td>
                                <td><?= date('H:i', strtotime($o['opened_at'])) ?></td>
                                <td><strong style="color:var(--gold)"><?= formatPrice($o['total'] ?? 0) ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php if (!empty($daily)): ?>
<div class="card" style="margin-top:1.25rem;">
    <div class="card-header">
        <h2><i class="fas fa-chart-line"></i> Order theo ngày</h2>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr><th>Ngày</th><th>Số order</th><th>Doanh thu</th></tr>
            </thead>
            <tbody>
                <?php foreach ($daily as $d): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($d['day'])) ?></td>
                        <td><?= $d['orders'] ?></td>
                        <td><strong style="color:var(--gold)"><?= formatPrice($d['revenue'] ?? 0) ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>
