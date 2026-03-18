<?php // views/orders/index.php — Clean White Theme Order Detail View
$draftItems = [];
$confirmedItems = [];
$hasDraft = false;

if (!empty($items)) {
    foreach ($items as $item) {
        if (($item['status'] ?? 'draft') === 'confirmed') {
            $confirmedItems[] = $item;
        } else {
            $draftItems[] = $item;
            $hasDraft = true;
        }
    }
}
?>

<div class="page-content">

    <?php if (!$order): ?>
        <!-- Empty State: No Order -->
        <div class="empty-state py-5 text-center">
            <i class="fas fa-receipt fa-4x mb-3 opacity-40"></i>
            <h4 class="fw-bold mt-3">Bàn chưa có order</h4>
            <p class="text-muted small mt-2">Quay lại sơ đồ bàn để bắt đầu phục vụ.</p>
            <a href="<?= BASE_URL ?>/tables" class="btn btn-gold px-5 py-3 mt-4 shadow-lg">
                <i class="fas fa-arrow-left me-2"></i>VỀ SƠ ĐỒ BÀN
            </a>
        </div>
    <?php else: ?>

        <!-- Table Identity Card -->
        <div class="identity-card shadow-sm">
            <div class="d-flex align-items-center">
                <div class="id-icon">
                    <span class="id-num"><?= e(str_replace('Bàn ', '', $table['name'])) ?></span>
                </div>
                <div class="id-main ms-3">
                    <h2 class="mb-1"><?= e($table_display_name) ?></h2>
                    <?php if (!empty($order['note'])): ?>
                        <div class="badge bg-gold-light text-gold-dark mb-2 py-2 px-3 rounded-pill" style="font-size:0.75rem; border:1px solid var(--gold-light);">
                            <i class="fas fa-info-circle me-1"></i> <?= e($order['note']) ?>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex gap-2 small">
                        <span>
                            <i class="fas fa-clock text-gold me-1"></i>
                            <?= date('H:i', strtotime($order['opened_at'])) ?>
                        </span>
                        <span class="clickable-update-guest" onclick="Aurora.openModal('modalUpdateGuestCount')" title="Cập nhật số khách">
                            <i class="fas fa-user-friends text-gold me-1"></i>
                            <span id="displayGuestCount"><?= $order['guest_count'] ?> khách</span>
                            <i class="fas fa-edit ms-1 opacity-50"></i>
                        </span>
                        <span>
                            <i class="fas fa-user-circle text-gold me-1"></i>
                            <?= e($order['waiter_name']) ?>
                        </span>
                    </div>
                </div>
                <div class="id-actions ms-auto">
                    <a href="<?= BASE_URL ?>/menu?table_id=<?= $table['id'] ?>&order_id=<?= $order['id'] ?>"
                        class="btn btn-gold btn-sm">
                        <i class="fas fa-plus me-1"></i> THÊM MÓN
                    </a>
                </div>
            </div>
        </div>

        <!-- Merge Suggestion Alert -->
        <?php if (!empty($mergeSuggestion)): ?>
            <div class="alert alert-warning" role="alert">
                <i class="fas fa-exclamation-triangle fa-lg"></i>
                <div><?= $mergeSuggestion ?></div>
                <button type="button" class="btn btn-sm btn-ghost"
                    onclick="Aurora.openModal('modalMergeAreaFromOrder')">
                    <i class="fas fa-object-group me-1"></i> Ghép bàn
                </button>
            </div>
        <?php endif; ?>

        <!-- Order Items Stream -->
        <div class="order-stream">

            <!-- Confirmed Items Section -->
            <?php if (!empty($confirmedItems)): ?>
                <div class="section-label">
                    <i class="fas fa-check-circle me-1"></i> ĐÃ XÁC NHẬN
                </div>
                <div class="items-grid-confirmed">
                    <?php
                    // Group confirmed items by set
                    $groupedConfirmedItems = [];
                    foreach ($confirmedItems as $item) {
                        $setNote = '';
                        if (preg_match('/^Set:\s*(.+)$/', $item['note'] ?? '', $matches)) {
                            $setNote = $matches[1];
                        }
                        $groupedConfirmedItems[$setNote][] = $item;
                    }

                    foreach ($groupedConfirmedItems as $setNote => $itemsInSet):
                        ?>
                        <?php if ($setNote): ?>
                            <div class="set-label">
                                <span class="badge-gold">
                                    <i class="fas fa-layer-group me-1"></i> <?= e($setNote) ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <?php foreach ($itemsInSet as $item): ?>
                            <div class="item-plate plate-confirmed">
                                <div class="plate-info">
                                    <div class="plate-name"><?= e($item['item_name']) ?></div>
                                    <?php if ($item['note'] && !preg_match('/^Set:\s*.+$/', $item['note'])): ?>
                                        <div class="plate-note">
                                            <i class="fas fa-comment-dots me-1"></i> <?= e($item['note']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="plate-qty">x<?= $item['quantity'] ?></div>
                                <div class="plate-price"><?= formatPrice($item['item_price'] * $item['quantity']) ?></div>
                                <div class="plate-status">
                                    <i class="fas fa-check-circle" title="Đã xác nhận"></i>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Draft Items Section -->
            <?php if (!empty($draftItems)): ?>
                <div class="section-label text-warning mt-4">
                    <i class="fas fa-clock me-1"></i> CHỜ GỬI BẾP
                </div>
                <div class="items-grid-draft">
                    <?php
                    // Group draft items by set
                    $groupedDraftItems = [];
                    foreach ($draftItems as $item) {
                        $setNote = '';
                        if (preg_match('/^Set:\s*(.+)$/', $item['note'] ?? '', $matches)) {
                            $setNote = $matches[1];
                        }
                        $groupedDraftItems[$setNote][] = $item;
                    }

                    foreach ($groupedDraftItems as $setNote => $itemsInSet):
                        ?>
                        <?php if ($setNote): ?>
                            <div class="set-label">
                                <span class="badge-gold">
                                    <i class="fas fa-layer-group me-1"></i> <?= e($setNote) ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <?php foreach ($itemsInSet as $item): ?>
                            <div class="item-plate plate-draft">
                                <div class="plate-info">
                                    <div class="plate-name"><?= e($item['item_name']) ?></div>
                                    <?php if ($item['note'] && !preg_match('/^Set:\s*.+$/', $item['note'])): ?>
                                        <div class="plate-note">
                                            <i class="fas fa-comment-dots me-1"></i> <?= e($item['note']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="plate-controls">
                                    <button class="q-btn" onclick="changeQty(<?= $item['id'] ?>, <?= $order['id'] ?>, -1)" title="Giảm">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="q-val" id="qty-<?= $item['id'] ?>"><?= $item['quantity'] ?></span>
                                    <button class="q-btn" onclick="changeQty(<?= $item['id'] ?>, <?= $order['id'] ?>, 1)" title="Tăng">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="plate-price-total"><?= formatPrice($item['item_price'] * $item['quantity']) ?></div>
                                <button class="plate-del" onclick="removeItem(<?= $item['id'] ?>, <?= $order['id'] ?>)" title="Xóa món">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Empty Items State -->
            <?php if (empty($items)): ?>
                <div class="card text-center py-5 opacity-40 border-dashed">
                    <i class="fas fa-coffee fa-3x mb-3"></i>
                    <p class="fw-bold">Chưa chọn món nào</p>
                    <a href="<?= BASE_URL ?>/menu?table_id=<?= $table['id'] ?>&order_id=<?= $order['id'] ?>"
                        class="btn btn-gold mt-3">
                        <i class="fas fa-plus me-1"></i> CHỌN MÓN NGAY
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Floating Bill Bar -->
        <div class="bill-dock">
            <div class="dock-summary">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="dock-label">TỔNG TẠM TÍNH</div>
                        <div class="dock-amount" id="orderTotal"><?= formatPrice($total) ?></div>
                    </div>
                    <div class="text-end">
                        <div class="small text-muted">Đã bao gồm VAT</div>
                    </div>
                </div>

                <div class="actions-container">
                    <?php if ($hasDraft): ?>
                        <form method="POST" action="<?= BASE_URL ?>/orders/confirm">
                            <input type="hidden" name="table_id" value="<?= $table['id'] ?>">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <button type="submit" class="btn btn-gold w-100 py-3 shadow-lg pulse-animation">
                                <i class="fas fa-concierge-bell me-2"></i> XÁC NHẬN ORDER
                            </button>
                        </form>
                    <?php endif; ?>

                    <div class="d-flex gap-2">
                        <?php if ($total > 0): ?>
                            <button class="btn btn-success-luxury w-100 py-3"
                                onclick="confirmPayment(<?= $table['id'] ?>, <?= $order['id'] ?>, <?= $total ?>)">
                                <i class="fas fa-credit-card me-2"></i> THANH TOÁN
                            </button>
                            <a href="<?= BASE_URL ?>/orders/print?order_id=<?= $order['id'] ?>" target="_blank"
                                class="btn btn-ghost py-3" style="min-width: 120px;">
                                <i class="fas fa-print me-1"></i> IN BILL
                            </a>
                        <?php else: ?>
                            <button class="btn btn-outline-danger w-100 py-3"
                                onclick="confirmClose(<?= $table['id'] ?>, <?= $order['id'] ?>)">
                                <i class="fas fa-door-closed me-2"></i> ĐÓNG BÀN
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>

<!-- ==================== MODALS ==================== -->

<!-- Modal: Payment -->
<div class="modal-backdrop" id="modalClose">
    <div class="modal">
        <div class="modal-header">
            <h3><i class="fas fa-check-circle me-2"></i> THANH TOÁN</h3>
            <button class="modal-close" data-modal-close type="button">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div id="paymentSummary" class="text-center mb-4">
                <div class="text-muted small fw-bold text-uppercase">Cần thanh toán</div>
                <div class="display-5 fw-bold text-gold py-2" id="modalTotalAmount"><?= formatPrice($total) ?></div>
            </div>

            <form method="POST" action="<?= BASE_URL ?>/tables/close" id="formCloseTable">
                <input type="hidden" name="table_id" id="closeTableId">
                <input type="hidden" name="order_id" id="closeOrderId">
                <input type="hidden" id="isQuickCancel" value="0">

                <div class="form-group">
                    <label class="form-label">PHƯƠNG THỨC THANH TOÁN</label>
                    <div class="payment-grid mb-4">
                        <label class="pay-btn">
                            <input type="radio" name="payment_method" value="cash" checked>
                            <span class="pay-cell">
                                <i class="fas fa-money-bill-wave"></i>
                                <span class="ms-1">TIỀN MẶT</span>
                            </span>
                        </label>
                        <label class="pay-btn">
                            <input type="radio" name="payment_method" value="transfer">
                            <span class="pay-cell">
                                <i class="fas fa-university"></i>
                                <span class="ms-1">CHUYỂN KHOẢN</span>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="mb-3 p-3 rounded-pill bg-light d-flex align-items-center gap-2">
                    <input type="checkbox" id="checkPaid" required>
                    <label for="checkPaid" class="small fw-bold m-0">Đã nhận đủ tiền từ khách hàng</label>
                </div>

                <div class="mb-4 p-3 rounded bg-light d-flex align-items-center gap-2">
                    <input type="checkbox" id="checkPrintBill">
                    <label for="checkPrintBill" class="small fw-bold m-0">
                        <i class="fas fa-print me-1"></i> Xem hoá đơn sau thanh toán
                    </label>
                </div>

                <button type="button" id="btnSubmitPayment" class="btn btn-gold w-100 py-3 shadow-lg"
                    onclick="handleSubmitPayment(event)">
                    <i class="fas fa-check-circle me-2"></i> HOÀN TẤT THANH TOÁN
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Update Guest Count -->
<div class="modal-backdrop" id="modalUpdateGuestCount">
    <div class="modal">
        <div class="modal-header">
            <h3><i class="fas fa-user-friends me-2"></i> Cập nhật số khách</h3>
            <button class="modal-close" data-modal-close type="button">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" id="formUpdateGuestCount" class="modal-body">
            <input type="hidden" name="order_id" value="<?= $order['id'] ?? '' ?>">
            <p class="small text-muted mb-3">Chọn hoặc nhập số lượng khách thực tế tại bàn.</p>
            
            <div class="form-group mb-4">
                <label class="form-label">SỐ LƯỢNG KHÁCH</label>
                <div class="guest-selector-grid">
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <label class="guest-option">
                            <input type="radio" name="guest_count_radio" value="<?= $i ?>" 
                                <?= $i == ($order['guest_count'] ?? 1) ? 'checked' : '' ?>>
                            <span class="guest-option-span"><?= $i ?></span>
                        </label>
                    <?php endfor; ?>
                </div>
                <div class="d-flex align-items-center mt-3">
                    <label class="me-3 small fw-bold">Hoặc nhập:</label>
                    <input type="number" name="guest_count_input" class="form-control flex-grow-1" 
                        min="1" value="<?= $order['guest_count'] ?? 1 ?>">
                </div>
            </div>
            
            <button type="button" onclick="submitGuestCountUpdate()" class="btn btn-gold w-100 py-3 fw-bold">
                <i class="fas fa-save me-2"></i> LƯU THAY ĐỔI
            </button>
        </form>
    </div>
</div>

<!-- Modal: Merge Tables -->
<div class="modal-backdrop" id="modalMergeAreaFromOrder">
    <div class="modal">
        <div class="modal-header">
            <h3><i class="fas fa-object-group me-2"></i> Ghép bàn</h3>
            <button class="modal-close" data-modal-close type="button">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="targetForm" method="POST" action="<?= BASE_URL ?>/tables/merge" class="modal-body">
            <input type="hidden" name="parent_id" value="<?= $table['id'] ?? '' ?>">
            <input type="hidden" name="redirect"
                value="/orders?table_id=<?= $table['id'] ?? '' ?>&order_id=<?= $order['id'] ?? '' ?>">
            
            <p class="merge-message">
                Chọn bàn trống cùng khu vực để ghép với <strong><?= e($table['name']) ?></strong>:
            </p>
            
            <div class="form-group mb-4">
                <label class="form-label">CHỌN BÀN TRỐNG</label>
                <select name="child_id" class="form-control" required>
                    <option value="">-- Chọn bàn --</option>
                    <?php
                    if (!empty($grouped)):
                        $currentArea = $table['area'] ?? '';
                        if (isset($grouped[$currentArea])):
                            $tables = $grouped[$currentArea];
                            foreach ($tables as $t):
                                if ($t['status'] === 'available' && empty($t['parent_id']) && $t['id'] != ($table['id'] ?? 0)):
                                    ?>
                                    <option value="<?= $t['id'] ?>">
                                        <?= e($t['name']) ?> (Sức chứa: <?= $t['capacity'] ?> ghế)
                                    </option>
                                    <?php
                                endif;
                            endforeach;
                        endif;
                    endif;
                    ?>
                </select>
            </div>
            
            <button type="submit" class="btn btn-gold w-100 py-3 fw-bold">
                <i class="fas fa-link me-2"></i> GHÉP BÀN NGAY
            </button>
        </form>
    </div>
</div>

<!-- External CSS -->
<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/orders/index.css">

<!-- Config -->
<script>
const ORDERS_CONFIG = {
    baseUrl: '<?= BASE_URL ?>'
};
</script>

<!-- External JavaScript -->
<script src="<?= BASE_URL ?>/public/js/orders/index.js"></script>
