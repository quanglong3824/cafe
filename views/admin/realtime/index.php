<?php
// views/admin/realtime/index.php
?>

<div class="realtime-dashboard">
    <!-- Premium Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chair"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value" id="statOccupied"><?= $counts['occupied'] ?></div>
                <div class="stat-label">Bàn đang ăn</div>
            </div>
        </div>

        <div class="stat-card" style="border-color: rgba(16, 185, 129, 0.2);">
            <div class="stat-icon"
                style="background: rgba(16, 185, 129, 0.1); color: var(--success); border-color: rgba(16, 185, 129, 0.2);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value" id="statAvailable" style="color: var(--success);"><?= $counts['available'] ?></div>
                <div class="stat-label">Bàn trống</div>
            </div>
        </div>

        <div class="stat-card" style="grid-column: span 2;">
            <div class="stat-info"
                style="width: 100%; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div class="stat-label">Tự động cập nhật</div>
                    <div style="font-size: 0.9rem; color: var(--text-light);"><i
                            class="fas fa-sync-alt fa-spin me-1"></i> Làm mới sau <span id="reloadCount"
                            class="fw-bold text-white">8</span> giây</div>
                </div>
                <button onclick="refreshData()" class="btn btn-gold btn-sm">
                    <i class="fas fa-redo"></i> CẬP NHẬT NGAY
                </button>
            </div>
        </div>
    </div>

    <!-- Active Orders Section -->
    <div class="card card-premium">
        <div class="card-header">
            <h2 class="playfair"><i class="fas fa-satellite-dish me-2"></i> Giám sát bàn trực tiếp</h2>
            <div class="badge badge-gold" id="activeCountBadge"><?= count($orders) ?> active</div>
        </div>

        <div id="realtimeListContainer">
            <!-- Content will be rendered by JS -->
            <div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x"></i> Đang tải...</div>
        </div>
    </div>
</div>

<script>
    let timerCount = 8;
    let isRefreshing = false;

    async function refreshData() {
        if (isRefreshing) return;
        isRefreshing = true;

        const btn = document.querySelector('button[onclick="refreshData()"]');
        const icon = btn?.querySelector('i');
        if (icon) icon.className = 'fas fa-sync fa-spin';

        try {
            const res = await fetch('<?= BASE_URL ?>/admin/realtime/data?t=' + Date.now());
            const data = await res.json();
            
            if (data.ok) {
                updateStats(data.counts);
                renderRealtimeList(data.data);
            }
        } catch (err) {
            console.error('Lỗi đồng bộ:', err);
        } finally {
            if (icon) icon.className = 'fas fa-redo';
            isRefreshing = false;
            timerCount = 8;
        }
    }

    function updateStats(counts) {
        document.getElementById('statOccupied').textContent = counts.occupied;
        document.getElementById('statAvailable').textContent = counts.available;
        document.getElementById('activeCountBadge').textContent = counts.occupied + ' active';
    }

    function renderRealtimeList(orders) {
        const container = document.getElementById('realtimeListContainer');
        if (orders.length === 0) {
            container.innerHTML = `
                <div class="empty-state py-5 text-center">
                    <i class="fas fa-mug-hot fa-3x mb-3 opacity-20"></i>
                    <h4 class="text-muted">Nhà hàng đang yên tĩnh</h4>
                    <p class="small text-muted">Hiện tại không có bàn nào đang hoạt động.</p>
                </div>
            `;
            return;
        }

        let html = '<div class="accordion custom-accordion" id="realtimeAccordion">';
        orders.forEach(order => {
            const isClosed = (order.status === 'closed');
            const itemsHtml = order.items.map(it => `
                <tr>
                    <td>
                        <div class="item-name">${it.item_name}</div>
                        ${it.note ? `<div class="item-note"><i class="fas fa-comment-dots text-warning"></i> ${it.note}</div>` : ''}
                    </td>
                    <td class="text-center fw-bold">x${it.quantity}</td>
                    <td class="text-end opacity-70">${it.item_price_fmt}</td>
                    <td class="text-end fw-bold text-white">${it.subtotal_fmt}</td>
                </tr>
            `).join('');

            html += `
                <div class="accordion-item" id="order-row-${order.id}">
                    <div class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${order.id}">
                            <div class="acc-header-content">
                                <div class="acc-id-circle"><i class="fas fa-chevron-right arrow"></i></div>
                                <div class="acc-main-info">
                                    <div class="acc-title">${order.full_name}</div>
                                    <div class="acc-sub">
                                        <span class="badge ${isClosed ? 'badge-success' : 'badge-warning'}">
                                            ${isClosed ? 'ĐÃ THANH TOÁN' : 'ĐANG PHỤC VỤ'}
                                        </span>
                                        <span class="acc-meta">
                                            <i class="fas fa-clock"></i> ${isClosed ? order.closed_at_fmt : order.opened_at_fmt}
                                            <span class="mx-1">|</span>
                                            <i class="fas fa-user-friends"></i> ${order.guest_count} khách
                                        </span>
                                    </div>
                                </div>
                                <div class="acc-price-box">
                                    <div class="acc-price-label">TỔNG CỘNG</div>
                                    <div class="acc-price-val ${isClosed ? 'text-success' : 'text-gold'}">${order.total_fmt}</div>
                                </div>
                            </div>
                        </button>
                        <div class="acc-actions">
                            <button onclick="dismissOrder(${order.id})" class="dismiss-btn" title="Ẩn đơn này">
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </div>
                    </div>
                    <div id="collapse-${order.id}" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="row g-4">
                                <div class="col-lg-8">
                                    <div class="items-list-card">
                                        <div class="it-card-header">CHI TIẾT MÓN ĂN</div>
                                        <div class="table-responsive">
                                            <table class="table table-dark-luxury m-0">
                                                <thead>
                                                    <tr>
                                                        <th>Món ăn / Ghi chú</th>
                                                        <th class="text-center">Số lượng</th>
                                                        <th class="text-end">Đơn giá</th>
                                                        <th class="text-end">Thành tiền</th>
                                                    </tr>
                                                </thead>
                                                <tbody>${itemsHtml}</tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="info-sidebar-card">
                                        <div class="it-card-header">LỊCH SỬ & NHÂN VIÊN</div>
                                        <div class="info-row"><span>Nhân viên phục vụ:</span> <strong>${order.waiter_name || 'N/A'}</strong></div>
                                        <div class="info-row"><span>Số đợt gọi món:</span> <span class="badge badge-info">${order.rounds} đợt</span></div>
                                        <div class="info-row"><span>Khu vực bàn:</span> <strong>${order.table_area}</strong></div>
                                        <div class="info-row"><span>Giờ mở bàn:</span> <strong>${order.opened_at_fmt}</strong></div>
                                        <hr class="my-3 opacity-10">
                                        <button onclick="dismissOrder(${order.id})" class="btn btn-gold w-100">
                                            <i class="fas fa-archive me-2"></i> LƯU TRỮ VÀ ẨN
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        
        // Cần giữ lại trạng thái collapse nếu đang mở?
        // Để đơn giản, ta chỉ render lại. Nếu muốn xịn hơn thì check DOM cũ.
        container.innerHTML = html;
    }

    async function dismissOrder(id) {
        if (!confirm('Ẩn đơn này khỏi danh sách giám sát?')) return;
        try {
            const fd = new FormData();
            fd.append('order_id', id);
            const res = await fetch('<?= BASE_URL ?>/admin/realtime/dismiss', { method: 'POST', body: fd });
            const data = await res.json();
            if (data.ok) {
                const row = document.getElementById(`order-row-${id}`);
                if (row) row.style.opacity = '0.3';
                refreshData(); // Cập nhật lại list sau khi ẩn
            }
        } catch (err) { console.error(err); }
    }

    setInterval(() => {
        timerCount--;
        if (timerCount <= 0) refreshData();
        const el = document.getElementById('reloadCount');
        if (el) el.textContent = timerCount;
    }, 1000);

    // Initial load
    refreshData();
</script>