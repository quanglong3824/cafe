<?php // views/admin/tables/index.php ?>
<div class="content-with-aside content-with-aside--sm">

    <!-- Table list -->
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-chair"></i> Danh sách Bàn</h2>
            <span class="badge badge-gold"><?= count($tables) ?> bàn</span>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tên bàn</th>
                        <th class="table-hide-sm">Khu vực</th>
                        <th class="table-hide-sm">Sức chứa</th>
                        <th>Trạng thái</th>
                        <th>Kích hoạt</th>
                        <th style="width:160px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tables as $t): ?>
                        <tr>
                            <td><strong><?= e($t['name']) ?></strong></td>
                            <td class="table-hide-sm"><?= e($t['area'] ?? '—') ?></td>
                            <td class="table-hide-sm"><?= $t['capacity'] ?> người</td>
                            <td>
                                <?php if ($t['status'] === 'occupied'): ?>
                                    <span class="badge badge-danger">
                                        <i class="fas fa-circle" style="font-size:.5rem"></i> Có khách
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-success">
                                        <i class="fas fa-circle" style="font-size:.5rem"></i> Trống
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge <?= $t['is_active'] ? 'badge-success' : 'badge-danger' ?>">
                                    <?= $t['is_active'] ? 'Đang dùng' : 'Tạm ẩn' ?>
                                </span>
                            </td>
                            <td>
                                <div style="display:flex;gap:.4rem;">
                                    <!-- QR Button -->
                                    <button type="button" class="btn btn-outline btn-sm btn-qr" data-id="<?= $t['id'] ?>"
                                        data-name="<?= e($t['name']) ?>" data-token="<?= e($t['qr_token'] ?? '') ?>" title="Tạo QR">
                                        <i class="fas fa-qrcode"></i>
                                    </button>

                                    <!-- Reset QR Button -->
                                    <button type="button" class="btn btn-outline btn-sm" style="color:var(--warning);" title="Tạo/Reset mã QR"
                                        onclick="confirmResetQR(<?= $t['id'] ?>, '<?= e($t['name']) ?>', <?= (int)$t['is_printed'] ?>, <?= (int)$t['scan_count'] ?>, <?= (int)$t['items_count'] ?>)">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>

                                    <a href="<?= BASE_URL ?>/admin/tables/edit?id=<?= $t['id'] ?>"
                                        class="btn btn-outline btn-sm" title="Sửa">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <?php if ($t['status'] !== 'occupied'): ?>
                                        <form method="POST" action="<?= BASE_URL ?>/admin/tables/delete"
                                            style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $t['id'] ?>">
                                            <button type="submit" class="btn btn-danger-outline btn-sm"
                                                data-confirm="Xóa bàn '<?= e($t['name']) ?>'?" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($tables)): ?>
                        <tr>
                            <td colspan="7" style="text-align:center;padding:2rem;color:#9ca3af;">
                                Chưa có bàn nào.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add / Edit form -->
    <div class="card sticky-aside">
        <?php if ($editItem): ?>
            <!-- Edit mode -->
            <div class="card-header">
                <h2><i class="fas fa-pen"></i> Sửa Bàn</h2>
                <a href="<?= BASE_URL ?>/admin/tables" class="btn btn-outline btn-sm">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/admin/tables/update">
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">

                <div class="form-group">
                    <label class="form-label">Tên bàn *</label>
                    <input type="text" name="name" class="form-control" required value="<?= e($editItem['name']) ?>"
                        placeholder="VD: Bàn 01">
                </div>
                <div class="form-group">
                    <label class="form-label">Khu vực</label>
                    <input type="text" name="area" class="form-control" value="<?= e($editItem['area'] ?? '') ?>"
                        placeholder="VD: Tầng 1, Sân vườn...">
                </div>
                <div class="form-group">
                    <label class="form-label">Sức chứa (người)</label>
                    <input type="number" name="capacity" class="form-control" min="1" max="20"
                        value="<?= (int) $editItem['capacity'] ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Thứ tự hiển thị</label>
                    <input type="number" name="sort_order" class="form-control" min="0"
                        value="<?= (int) $editItem['sort_order'] ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Trạng thái</label>
                    <select name="is_active" class="form-control">
                        <option value="1" <?= $editItem['is_active'] ? 'selected' : '' ?>>Đang dùng</option>
                        <option value="0" <?= !$editItem['is_active'] ? 'selected' : '' ?>>Tạm ẩn</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-gold btn-block">
                    <i class="fas fa-save"></i> Lưu thay đổi
                </button>
            </form>

        <?php else: ?>
            <!-- Add mode -->
            <div class="card-header">
                <h2><i class="fas fa-plus"></i> Thêm Bàn</h2>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/admin/tables/store">
                <div class="form-group">
                    <label class="form-label">Tên bàn *</label>
                    <input type="text" name="name" class="form-control" required placeholder="VD: Bàn 01">
                </div>
                <div class="form-group">
                    <label class="form-label">Khu vực</label>
                    <input type="text" name="area" class="form-control" placeholder="VD: Tầng 1, Sân vườn...">
                </div>
                <div class="form-group">
                    <label class="form-label">Sức chứa (người)</label>
                    <input type="number" name="capacity" class="form-control" min="1" max="20" value="4">
                </div>
                <div class="form-group">
                    <label class="form-label">Thứ tự hiển thị</label>
                    <input type="number" name="sort_order" class="form-control" value="0" min="0">
                </div>
                <button type="submit" class="btn btn-gold btn-block">
                    <i class="fas fa-save"></i> Thêm bàn
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>

<!-- QR Modal -->
<div id="qrModal" class="modal">
    <div class="modal-content" style="max-width: 450px;">
        <div class="modal-header">
            <h3 id="qrModalTitle">Mã QR Bàn</h3>
            <button type="button" class="close-modal">&times;</button>
        </div>
        <div class="modal-body" id="printableQrArea">
            <div class="qr-print-header" style="display:none; text-align:center; margin-bottom:20px;">
                <h1 style="font-family:'Playfair Display', serif; color:#D4AF37; margin:0; font-size:28px;">AURORA HOTEL PLAZA</h1>
                <p style="margin:5px 0 15px; font-size:14px; letter-spacing:2px; color:#666;">RESTAURANT & BAR</p>
                <div style="border-top:1px solid #D4AF37; border-bottom:1px solid #D4AF37; padding:10px 0; margin:10px 0;">
                    <h2 id="qrTableDisplay" style="margin:0; font-size:24px; color:#1a1a1a;">BÀN 01</h2>
                </div>
            </div>
            
            <div id="qrcode" style="display: flex; justify-content: center; margin-bottom: 1.5rem; padding:15px; background:#fff; border-radius:12px;"></div>
            
            <div class="qr-print-footer" style="display:none; text-align:center; margin-top:15px;">
                <p style="font-weight:600; margin-bottom:5px;">QUÉT MÃ ĐỂ ĐẶT MÓN</p>
                <p style="font-size:12px; color:#888;">Cảm ơn Quý khách / Thank you!</p>
            </div>

            <p id="qrUrl" style="font-size: 0.75rem; color: #999; word-break: break-all; margin-bottom: 1.5rem; font-family:monospace;"></p>
            
            <div style="display: flex; gap: 0.75rem; justify-content: center;" class="no-print">
                <button type="button" class="btn btn-gold" onclick="printQR()">
                    <i class="fas fa-print"></i> In QR
                </button>
                <button type="button" class="btn btn-outline" onclick="downloadQR()">
                    <i class="fas fa-download"></i> Tải ảnh
                </button>
                <button type="button" class="btn btn-outline close-modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* QR Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(8px);
    }

    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        position: relative;
        animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .close-modal {
        background: #f3f4f6;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
    }

    .close-modal:hover { background: #e5e7eb; }

    #qrcode img {
        border: 1px solid #f0f0f0;
        padding: 10px;
        border-radius: 8px;
    }

    @media print {
        body * { visibility: hidden; }
        #qrModal, #qrModal * { visibility: visible; }
        .modal { position: absolute; left: 0; top: 0; background: #fff; padding: 0; }
        .modal-content { box-shadow: none; margin: 0; border: none; width: 100%; max-width: none; }
        .no-print, .modal-header, #qrUrl { display: none !important; }
        .qr-print-header, .qr-print-footer { display: block !important; }
        #printableQrArea { padding: 40px !important; }
        #qrcode { margin: 0 auto !important; padding: 0 !important; }
        #qrcode img { width: 400px !important; height: 400px !important; border: none !important; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('qrModal');
        const qrContainer = document.getElementById('qrcode');
        const qrUrlText = document.getElementById('qrUrl');
        const qrTitle = document.getElementById('qrModalTitle');
        const qrTableDisplay = document.getElementById('qrTableDisplay');
        const closeBtns = document.querySelectorAll('.close-modal');

        document.querySelectorAll('.btn-qr').forEach(btn => {
            btn.addEventListener('click', () => {
                const tableId = btn.dataset.id;
                const tableName = btn.dataset.name;
                const token = btn.dataset.token;
                
                if (!token) {
                    if (confirm('Bàn này chưa có mã QR định danh. Bạn có muốn hệ thống tự động tạo mã ngay bây giờ?')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '<?= BASE_URL ?>/admin/qr-codes/generate';
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'table_id';
                        input.value = tableId;
                        form.appendChild(input);
                        document.body.appendChild(form);
                        form.submit();
                    }
                    return;
                }

                const fullUrl = `<?= BASE_URL ?>/q?t=${token}`;

                qrTitle.innerText = `Mã QR: ${tableName}`;
                qrTableDisplay.innerText = tableName.toUpperCase();
                qrUrlText.innerText = fullUrl;
                qrContainer.innerHTML = '';

                new QRCode(qrContainer, {
                    text: fullUrl,
                    width: 300,
                    height: 300,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.L,
                    margin: 2
                });

                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            });
        });

        closeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            });
        });

        window.onclick = (e) => {
            if (e.target == modal) {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        };
    });

    function printQR() {
        window.print();
    }

    function downloadQR() {
        const img = document.querySelector('#qrcode img');
        if (!img) return;
        const link = document.createElement('a');
        link.download = `QR-${document.getElementById('qrTableDisplay').innerText}.png`;
        link.href = img.src;
        link.click();
    }

    function confirmResetQR(tableId, tableName, isPrinted, scanCount, itemsCount) {
        let message = `Bạn có chắc chắn muốn làm mới mã QR cho ${tableName}?\n\n`;
        
        if (itemsCount > 0) {
            alert(`CẢNH BÁO: Bàn ${tableName} đang có khách đã đặt món (${itemsCount} món).\n\nVui lòng hoàn tất đơn hàng và thanh toán trước khi reset QR.`);
            return;
        }

        if (isPrinted) {
            if (!confirm(`Mã QR của ${tableName} ĐÃ ĐƯỢC IN ra giấy.\n\nNếu bạn reset, mã QR cũ trên giấy sẽ không còn tác dụng và khách không thể quét được nữa.\n\nBạn có CHẮC CHẮN vẫn muốn tạo mã mới?`)) {
                return;
            }
        } else if (scanCount > 0) {
             if (!confirm(`Mã QR này đã được quét ${scanCount} lần.\n\nBạn có chắc chắn muốn reset không?`)) {
                return;
            }
        } else {
            if (!confirm(`Xác nhận tạo mã QR mới cho ${tableName}?`)) {
                return;
            }
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= BASE_URL ?>/admin/qr-codes/generate';
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'table_id';
        input.value = tableId;
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
</script>