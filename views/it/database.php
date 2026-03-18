<?php // views/it/database.php ?>
<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-database"></i> Quản lý Cơ sở dữ liệu</h2>
        <div style="display:flex; gap:1rem;">
            <a href="<?= BASE_URL ?>/it/database/cleanup" class="btn btn-danger-outline">
                <i class="fas fa-broom"></i> Dọn dẹp CSDL
            </a>
            <a href="<?= BASE_URL ?>/it/database/backup" class="btn btn-gold">
                <i class="fas fa-plus"></i> Tạo bản sao lưu mới
            </a>
        </div>
    </div>
    <div class="card-body" style="padding: 2rem;">
        <div class="row" style="display: flex; gap: 2rem; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 300px;">
                <h3 style="margin-bottom: 1rem; color: var(--gold);">Sao lưu dữ liệu</h3>
                <p style="margin-bottom: 1.5rem; color: var(--text-muted); line-height: 1.6;">
                    Khi nhấn nút, hệ thống sẽ tự động tạo một bản sao lưu <code>.sql</code> và lưu vào thư mục <code>/backups</code>. 
                    Bạn có thể tải về hoặc xóa các bản cũ bên dưới.
                </p>
            </div>
            
            <div style="flex: 1; min-width: 300px; border-left: 1px solid var(--border); padding-left: 2rem;">
                <h3 style="margin-bottom: 1rem; color: var(--danger);">Phục hồi dữ liệu</h3>
                <p style="margin-bottom: 1.5rem; color: var(--text-muted); line-height: 1.6;">
                    <strong>Cảnh báo:</strong> Việc phục hồi sẽ ghi đè toàn bộ dữ liệu hiện tại. 
                    Hiện tại hãy thực hiện phục hồi thủ công qua phpMyAdmin với các file đã tải về.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2><i class="fas fa-history"></i> Danh sách các bản sao lưu</h2>
        <span class="badge badge-gold"><?= count($backups) ?> bản lưu</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Tên file</th>
                    <th>Ngày tạo</th>
                    <th>Kích thước</th>
                    <th style="width:150px">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($backups)): ?>
                    <tr>
                        <td colspan="4" style="text-align:center; padding: 2rem; color: var(--text-muted);">
                            Chưa có bản sao lưu nào.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($backups as $b): ?>
                        <tr>
                            <td><code class="chip"><?= e($b['name']) ?></code></td>
                            <td><?= date('d/m/Y H:i:s', strtotime($b['date'])) ?></td>
                            <td><?= round($b['size'] / 1024, 2) ?> KB</td>
                            <td>
                                <div style="display:flex; gap:.5rem;">
                                    <a href="<?= BASE_URL ?>/it/database/download?file=<?= urlencode($b['name']) ?>" 
                                       class="btn btn-outline btn-sm" title="Tải về">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <form method="POST" action="<?= BASE_URL ?>/it/database/delete" style="display:inline;" 
                                          onsubmit="return confirm('Xóa bản sao lưu này?')">
                                        <input type="hidden" name="file" value="<?= e($b['name']) ?>">
                                        <button type="submit" class="btn btn-danger-outline btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2><i class="fas fa-info-circle"></i> Thông tin hệ thống</h2>
    </div>
    <div class="table-wrap">
        <table>
            <tbody>
                <tr>
                    <td style="font-weight: 600; width: 200px;">Database Name</td>
                    <td><code><?= e(DB_NAME) ?></code></td>
                </tr>
                <tr>
                    <td style="font-weight: 600;">Host</td>
                    <td><code><?= e(DB_HOST) ?></code></td>
                </tr>
                <tr>
                    <td style="font-weight: 600;">Đường dẫn lưu trữ</td>
                    <td><code>/backups/</code></td>
                </tr>
                <tr>
                    <td style="font-weight: 600;">Kích thước Database hiện tại</td>
                    <td>
                        <?php
                        $db = getDB();
                        $q = $db->query("SELECT SUM(data_length + index_length) / 1024 / 1024 AS size FROM information_schema.TABLES WHERE table_schema = '" . DB_NAME . "'");
                        $size = $q->fetch()['size'];
                        echo round($size, 2) . ' MB';
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
