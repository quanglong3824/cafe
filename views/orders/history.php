<?php
// views/orders/history.php — Lịch sử giao dịch Aurora Restaurant
$page = $currentPage ?? 1;
$limit = 6;
$totalPages = $totalPages ?? 1;
$totalItems = $totalCount ?? 0;
$totalRevenueVal = $totalRevenue ?? 0;
$pagedOrders = $orders;

$filters = [
    'type' => $_GET['filter_type'] ?? 'date',
    'date' => $_GET['date'] ?? date('Y-m-d'),
    'week' => $_GET['week'] ?? date('W'),
    'month' => $_GET['month'] ?? date('n'),
    'year' => $_GET['year'] ?? date('Y'),
];
?>

<div class="history-container animate-fade-in">
    <!-- Header Section -->
    <header class="history-header">
        <div class="header-info">
            <h1 class="playfair">Lịch sử giao dịch</h1>
            <p class="text-muted">Theo dõi và quản lý doanh thu nhà hàng</p>
        </div>
        <div class="header-summary">
            <div class="summary-item main">
                <span class="label">Tổng doanh thu</span>
                <span class="value gold-glow"><?= formatPrice($totalRevenueVal) ?></span>
            </div>
            <div class="summary-item">
                <span class="label">Giao dịch</span>
                <span class="value"><?= number_format($totalItems) ?></span>
            </div>
        </div>
    </header>

    <!-- Filter Section -->
    <section class="history-filters">
        <form action="<?= BASE_URL ?>/orders/history" method="GET" id="historyFilterForm" class="filter-form">
            <div class="filter-type-switcher">
                <button type="button" class="switch-btn <?= $filters['type'] === 'date' ? 'active' : '' ?>" onclick="setFilter('date')">Ngày</button>
                <button type="button" class="switch-btn <?= $filters['type'] === 'week' ? 'active' : '' ?>" onclick="setFilter('week')">Tuần</button>
                <button type="button" class="switch-btn <?= $filters['type'] === 'month' ? 'active' : '' ?>" onclick="setFilter('month')">Tháng</button>
                <input type="hidden" name="filter_type" id="filter_type" value="<?= e($filters['type']) ?>">
            </div>

            <div class="filter-inputs">
                <?php if ($filters['type'] === 'date'): ?>
                    <div class="input-group-premium">
                        <i class="fas fa-calendar-day icon"></i>
                        <input type="date" name="date" class="form-control-premium" value="<?= e($filters['date']) ?>" onchange="this.form.submit()">
                    </div>
                <?php elseif ($filters['type'] === 'week'): ?>
                    <div class="input-row">
                        <div class="input-group-premium">
                            <i class="fas fa-calendar-week icon"></i>
                            <input type="number" name="week" class="form-control-premium" min="1" max="53" value="<?= e($filters['week']) ?>" placeholder="Tuần">
                        </div>
                        <div class="input-group-premium">
                            <i class="fas fa-calendar-alt icon"></i>
                            <input type="number" name="year" class="form-control-premium" value="<?= e($filters['year']) ?>" placeholder="Năm">
                        </div>
                        <button type="submit" class="btn-filter"><i class="fas fa-search"></i></button>
                    </div>
                <?php elseif ($filters['type'] === 'month'): ?>
                    <div class="input-row">
                        <div class="input-group-premium">
                            <i class="fas fa-calendar-alt icon"></i>
                            <select name="month" class="form-control-premium">
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?= $m ?>" <?= (int) $filters['month'] === $m ? 'selected' : '' ?>>Tháng <?= $m ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="input-group-premium">
                            <i class="fas fa-calendar-check icon"></i>
                            <input type="number" name="year" class="form-control-premium" value="<?= e($filters['year']) ?>" placeholder="Năm">
                        </div>
                        <button type="submit" class="btn-filter"><i class="fas fa-search"></i></button>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </section>

    <!-- Results Listing -->
    <main class="history-list">
        <?php if (empty($pagedOrders)): ?>
            <div class="empty-state animate-fade-in-up">
                <div class="empty-icon"><i class="fas fa-receipt"></i></div>
                <h3>Chưa có giao dịch</h3>
                <p>Không tìm thấy hóa đơn nào trong khoảng thời gian này.</p>
            </div>
        <?php else: ?>
            <div class="order-grid">
                <?php foreach ($pagedOrders as $order): ?>
                    <div class="order-card-new animate-fade-in-up">
                        <div class="card-header">
                            <div class="table-info">
                                <span class="table-tag"><?= e($order['table_area']) ?></span>
                                <h4 class="table-name"><?= e($order['table_name']) ?></h4>
                            </div>
                            <div class="order-status">
                                <span class="payment-badge <?= e($order['payment_method']) ?>">
                                    <?= strtoupper(e($order['payment_method'])) ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="meta-row">
                                <div class="meta-item">
                                    <i class="far fa-clock"></i>
                                    <span><?= date('H:i', strtotime($order['closed_at'])) ?></span>
                                </div>
                                <div class="meta-item">
                                    <i class="far fa-calendar-alt"></i>
                                    <span><?= date('d/m/Y', strtotime($order['closed_at'])) ?></span>
                                </div>
                            </div>
                            <div class="staff-info">
                                <i class="fas fa-user-tie"></i>
                                <span><?= e($order['waiter_name'] ?? 'Hệ thống') ?></span>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="total-info">
                                <span class="label">Tổng tiền</span>
                                <span class="amount"><?= formatPrice($order['total']) ?></span>
                            </div>
                            <div class="action-buttons">
                                <button type="button" class="btn-detail view-details-btn" 
                                    data-order-id="<?= $order['id'] ?>" 
                                    data-order-data="<?= htmlspecialchars(json_encode($order)) ?>">
                                    Chi tiết
                                </button>
                                <a href="<?= BASE_URL ?>/orders/print?order_id=<?= $order['id'] ?>" target="_blank" class="btn-print">
                                    <i class="fas fa-print"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Modern Pagination -->
            <?php if ($totalPages > 1): ?>
                <nav class="modern-pagination">
                    <?php
                    $queryParams = $_GET;
                    unset($queryParams['page']);
                    $queryString = http_build_query($queryParams);
                    $baseUrl = BASE_URL . '/orders/history?' . ($queryString ? $queryString . '&' : '');
                    ?>
                    <a href="<?= $page <= 1 ? 'javascript:void(0)' : $baseUrl . 'page=' . ($page - 1) ?>" class="pag-nav <?= $page <= 1 ? 'disabled' : '' ?>">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    
                    <div class="pag-pages">
                        <?php
                        $startPage = max(1, $page - 1);
                        $endPage = min($totalPages, $page + 1);
                        
                        if ($startPage > 1) {
                            echo '<a href="'.$baseUrl.'page=1" class="pag-item">1</a>';
                            if ($startPage > 2) echo '<span class="pag-ellipsis">...</span>';
                        }
                        
                        for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <a href="<?= $baseUrl ?>page=<?= $i ?>" class="pag-item <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                        <?php endfor; ?>
                        
                        <?php
                        if ($endPage < $totalPages) {
                            if ($endPage < $totalPages - 1) echo '<span class="pag-ellipsis">...</span>';
                            echo '<a href="'.$baseUrl.'page='.$totalPages.'" class="pag-item">'.$totalPages.'</a>';
                        }
                        ?>
                    </div>

                    <a href="<?= $page >= $totalPages ? 'javascript:void(0)' : $baseUrl . 'page=' . ($page + 1) ?>" class="pag-nav <?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    </main>
</div>

<!-- Modal Bottom Sheet -->
<div class="modal-backdrop" id="modalOrderDetails">
    <div class="bottom-sheet">
        <div class="sheet-handle"></div>
        <div class="sheet-header">
            <div class="header-main">
                <h3 id="modalTableTitle">Bàn 01</h3>
                <span id="modalOrderTime">20:30 • 18/03/2026</span>
            </div>
            <button class="sheet-close" data-modal-close><i class="fas fa-times"></i></button>
        </div>
        
        <div class="sheet-content" id="modalOrderBody">
            <div class="loading-spinner">
                <div class="spinner"></div>
            </div>
        </div>
        
        <div class="sheet-footer">
            <a href="#" target="_blank" class="btn-sheet-print" id="btnPrintOrder">
                <i class="fas fa-print me-2"></i> In hóa đơn
            </a>
            <button class="btn-sheet-close" data-modal-close>Đóng</button>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?= asset('public/css/orders/history.css') ?>">
<script src="<?= asset('public/js/orders/history.js') ?>" defer></script>
