<?php // views/it/cleanup.php ?>
<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-broom"></i> Dọn dẹp Cơ sở dữ liệu</h2>
        <a href="<?= BASE_URL ?>/it/database" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="card-body" style="padding: 2rem;">
        <div class="alert alert-danger" style="margin-bottom: 2rem; border-left: 5px solid #dc3545;">
            <h3 style="color: #dc3545; margin-bottom: 0.5rem;"><i class="fas fa-exclamation-triangle"></i> CẢNH BÁO NGUY HIỂM</h3>
            <p>Việc dọn dẹp sẽ <strong>xoá vĩnh viễn</strong> dữ liệu trong các bảng được chọn. Hãy đảm bảo bạn đã tạo bản sao lưu (Backup) trước khi thực hiện hành động này.</p>
        </div>

        <form action="<?= BASE_URL ?>/it/database/cleanup" method="POST" id="cleanupForm">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                
                <!-- Group 1: Transactions -->
                <div class="cleanup-option card" style="border: 1px solid var(--border); background: #fcfcfc;">
                    <div class="card-body">
                        <label style="display: flex; align-items: flex-start; gap: 1rem; cursor: pointer;">
                            <input type="checkbox" name="cleanup_types[]" value="orders" style="width: 20px; height: 20px; margin-top: 5px;">
                            <div>
                                <strong style="display: block; font-size: 1.1rem;">Dữ liệu Giao dịch (Orders)</strong>
                                <span style="color: var(--text-muted); font-size: 0.9rem;">
                                    Xoá sạch lịch sử Order, món ăn đã gọi, thông báo và yêu cầu hỗ trợ. 
                                    Trả toàn bộ bàn về trạng thái "Trống".
                                </span>
                                <div class="badge badge-outline mt-2"><?= $stats['orders'] ?> Orders / <?= $stats['notifications'] ?> Thông báo</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Group 2: Menu -->
                <div class="cleanup-option card" style="border: 1px solid var(--border); background: #fcfcfc;">
                    <div class="card-body">
                        <label style="display: flex; align-items: flex-start; gap: 1rem; cursor: pointer;">
                            <input type="checkbox" name="cleanup_types[]" value="menu" style="width: 20px; height: 20px; margin-top: 5px;">
                            <div>
                                <strong style="display: block; font-size: 1.1rem;">Danh mục & Món ăn</strong>
                                <span style="color: var(--text-muted); font-size: 0.9rem;">
                                    Xoá sạch toàn bộ Menu, Danh mục và các Set món ăn hiện có.
                                </span>
                                <div class="badge badge-outline mt-2"><?= $stats['menu_items'] ?> Món ăn</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Group 3: Tables -->
                <div class="cleanup-option card" style="border: 1px solid var(--border); background: #fcfcfc;">
                    <div class="card-body">
                        <label style="display: flex; align-items: flex-start; gap: 1rem; cursor: pointer;">
                            <input type="checkbox" name="cleanup_types[]" value="tables" style="width: 20px; height: 20px; margin-top: 5px;">
                            <div>
                                <strong style="display: block; font-size: 1.1rem;">Sơ đồ Bàn & Mã QR</strong>
                                <span style="color: var(--text-muted); font-size: 0.9rem;">
                                    Xoá sạch danh sách bàn và các mã QR tương ứng đã tạo.
                                </span>
                                <div class="badge badge-outline mt-2"><?= $stats['tables'] ?> Bàn</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Group 4: Sessions -->
                <div class="cleanup-option card" style="border: 1px solid var(--border); background: #fcfcfc;">
                    <div class="card-body">
                        <label style="display: flex; align-items: flex-start; gap: 1rem; cursor: pointer;">
                            <input type="checkbox" name="cleanup_types[]" value="sessions" style="width: 20px; height: 20px; margin-top: 5px;">
                            <div>
                                <strong style="display: block; font-size: 1.1rem;">Phiên khách hàng (Sessions)</strong>
                                <span style="color: var(--text-muted); font-size: 0.9rem;">
                                    Xoá thông tin các khách hàng đang truy cập menu qua QR.
                                </span>
                                <div class="badge badge-outline mt-2"><?= $stats['sessions'] ?> Phiên</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Group 5: Logs -->
                <div class="cleanup-option card" style="border: 1px solid var(--border); background: #fcfcfc;">
                    <div class="card-body">
                        <label style="display: flex; align-items: flex-start; gap: 1rem; cursor: pointer;">
                            <input type="checkbox" name="cleanup_types[]" value="logs" style="width: 20px; height: 20px; margin-top: 5px;">
                            <div>
                                <strong style="display: block; font-size: 1.1rem;">Lịch sử ca làm việc</strong>
                                <span style="color: var(--text-muted); font-size: 0.9rem;">
                                    Xoá dữ liệu phân ca và lịch sử làm việc của nhân viên.
                                </span>
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            <div style="margin-top: 3rem; text-align: center; border-top: 1px solid var(--border); padding-top: 2rem;">
                <p style="margin-bottom: 1rem; font-weight: 600;">Nhập mật mã xác nhận dọn dẹp:</p>
                <input type="password" id="confirmCode" placeholder="Nhập 'CONFIRM'" 
                       style="padding: 0.8rem 1.5rem; border: 2px solid var(--border); border-radius: 10px; text-align: center; font-family: monospace; letter-spacing: 2px; margin-bottom: 1.5rem;">
                <br>
                <button type="submit" class="btn btn-danger btn-lg" style="padding: 1rem 3rem;">
                    <i class="fas fa-trash-alt"></i> XÁC NHẬN DỌN DẸP NGAY
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('cleanupForm').addEventListener('submit', function(e) {
    const code = document.getElementById('confirmCode').value;
    const checks = document.querySelectorAll('input[name="cleanup_types[]"]:checked');
    
    if (checks.length === 0) {
        e.preventDefault();
        alert('Vui lòng chọn ít nhất một mục để dọn dẹp.');
        return;
    }
    
    if (code !== 'CONFIRM') {
        e.preventDefault();
        alert('Vui lòng nhập đúng mã xác nhận "CONFIRM" (viết hoa) để thực hiện hành động này.');
        return;
    }
    
    if (!confirm('HÀNH ĐỘNG NÀY KHÔNG THỂ HOÀN TÁC! Bạn có chắc chắn muốn dọn dẹp dữ liệu đã chọn?')) {
        e.preventDefault();
    }
});
</script>

<style>
.cleanup-option:hover {
    border-color: var(--danger) !important;
    background: #fff5f5 !important;
}
.badge-outline {
    border: 1px solid var(--border);
    color: var(--text-light);
    background: transparent;
    padding: 2px 10px;
    border-radius: 50px;
}
.mt-2 { margin-top: 0.5rem; }
</style>