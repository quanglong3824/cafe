<?php // views/admin/tables/qr_codes.php — QR Code Management ?>
<div class="admin-container">
    <div class="admin-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1><i class="fas fa-qrcode me-2"></i> Quản lý mã QR</h1>
            <p class="text-muted">Tạo và quản lý mã QR đặt món cho từng bàn.</p>
        </div>
        <button class="btn-gold" onclick="document.getElementById('modalGenerateQr').classList.add('show')">
            <i class="fas fa-plus me-1"></i> Tạo mã QR mới
        </a>
    </div>

    <div class="card premium-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Bàn</th>
                            <th>Khu vực</th>
                            <th>Token</th>
                            <th>Số lần quét</th>
                            <th>Lần quét cuối</th>
                            <th class="text-end pe-4">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($qrCodes)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Chưa có mã QR nào được tạo.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($qrCodes as $qr): ?>
                                <tr>
                                    <td class="ps-4"><strong><?= e($qr['table_name']) ?></strong></td>
                                    <td><span class="badge bg-outline-gold"><?= e($qr['table_area']) ?></span></td>
                                    <td><code class="small text-muted"><?= e($qr['qr_token']) ?></code></td>
                                    <td><?= number_format($qr['scan_count']) ?></td>
                                    <td class="small text-muted">
                                        <?= $qr['last_scanned_at'] ? date('d/m/Y H:i', strtotime($qr['last_scanned_at'])) : '—' ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="<?= BASE_URL ?>/qr/menu?table_id=<?= $qr['table_id'] ?>&token=<?= $qr['qr_token'] ?>" target="_blank" class="btn-icon" title="Xem thử">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>/admin/qr-codes/download?table_id=<?= $qr['table_id'] ?>&token=<?= $qr['qr_token'] ?>" class="btn-icon text-gold" title="Tải về/In">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button class="btn-icon text-danger" onclick="confirmDelete(<?= $qr['id'] ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Generate QR Modal -->
<div class="modal-backdrop" id="modalGenerateQr">
    <div class="modal modal-premium" style="max-width:450px;">
        <div class="modal-header">
            <h3>Tạo mã QR</h3>
            <button class="modal-close" onclick="this.closest('.modal-backdrop').classList.remove('show')"><i class="fas fa-times"></i></button>
        </div>
        <form action="<?= BASE_URL ?>/admin/qr-codes/generate" method="POST">
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Chọn bàn</label>
                    <select name="table_id" class="form-control" required>
                        <option value="">-- Chọn bàn --</option>
                        <?php foreach ($tables as $t): ?>
                            <option value="<?= $t['id'] ?>"><?= e($t['name']) ?> (<?= e($t['area']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <p class="small text-muted">
                    <i class="fas fa-info-circle me-1"></i> Nếu bàn đã có mã QR, mã mới sẽ ghi đè mã cũ.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" onclick="this.closest('.modal-backdrop').classList.remove('show')">Hủy</button>
                <button type="submit" class="btn-gold">Tạo mã</button>
            </div>
        </form>
    </div>
</div>

<style>
    .bg-outline-gold {
        border: 1px solid var(--gold);
        color: var(--gold-dark);
        background: transparent;
    }
    .btn-icon {
        background: none;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 1.1rem;
        color: var(--text-muted);
        transition: color 0.2s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-icon:hover {
        color: var(--gold);
    }
</style>

<script>
    function confirmDelete(id) {
        if (confirm('Bạn có chắc chắn muốn xóa mã QR này?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= BASE_URL ?>/admin/qr-codes/delete';
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'id';
            input.value = id;
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
