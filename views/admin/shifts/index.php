<?php // views/admin/shifts/index.php ?>
<div class="content-with-aside content-with-aside--sm">

    <!-- Danh sách ca trực & Phân công -->
    <div style="display: flex; flex-direction: column; gap: 1.25rem;">
        
        <!-- Phân công ca trực hôm nay -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-calendar-check"></i> Phân công ca hôm nay (<?= date('d/m/Y', strtotime($today)) ?>)</h2>
                <button class="btn btn-gold" onclick="Aurora.openModal('modalAssign')">
                    <i class="fas fa-user-plus"></i> Gán nhân viên
                </button>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Ca trực</th>
                            <th>Nhân viên</th>
                            <th style="width:100px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($assignments)): ?>
                        <tr><td colspan="3" class="text-center" style="padding: 2rem; color: var(--text-muted);">Chưa có nhân viên nào được phân công hôm nay.</td></tr>
                        <?php else: ?>
                            <?php foreach($assignments as $a): ?>
                            <tr>
                                <td><strong><?= e($a['shift_name']) ?></strong></td>
                                <td><?= e($a['user_name']) ?></td>
                                <td>
                                    <form method="POST" action="<?= BASE_URL ?>/admin/shifts/remove_assign" onsubmit="return confirm('Hủy phân công này?');">
                                        <input type="hidden" name="id" value="<?= $a['id'] ?>">
                                        <button type="submit" class="btn btn-danger-outline btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Danh sách các ca -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-clock"></i> Cấu hình Ca trực</h2>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Tên ca</th>
                            <th>Thời gian bắt đầu</th>
                            <th>Thời gian kết thúc</th>
                            <th style="width:100px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($shifts)): ?>
                        <tr><td colspan="4" class="text-center">Chưa cấu hình ca trực.</td></tr>
                        <?php else: ?>
                            <?php foreach($shifts as $s): ?>
                            <tr>
                                <td><strong><?= e($s['name']) ?></strong></td>
                                <td><?= date('H:i', strtotime($s['start_time'])) ?></td>
                                <td><?= date('H:i', strtotime($s['end_time'])) ?></td>
                                <td>
                                    <form method="POST" action="<?= BASE_URL ?>/admin/shifts/delete" onsubmit="return confirm('Xóa ca này? Việc này sẽ xóa cả dữ liệu phân công liên quan.');">
                                        <input type="hidden" name="id" value="<?= $s['id'] ?>">
                                        <button type="submit" class="btn btn-danger-outline btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Cột thêm ca mới -->
    <aside class="sticky-aside">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-plus"></i> Thêm Ca Mới</h2>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/admin/shifts/store">
                <div class="form-group">
                    <label class="form-label">Tên Ca (VD: Ca Sáng)</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Giờ bắt đầu</label>
                    <input type="time" name="start_time" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Giờ kết thúc</label>
                    <input type="time" name="end_time" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-gold btn-block">
                    <i class="fas fa-save"></i> Lưu ca trực
                </button>
            </form>
        </div>
    </aside>

</div>

<!-- Modal Gán Nhân Viên -->
<div class="modal-backdrop" id="modalAssign">
    <div class="modal" style="max-width: 400px;">
        <div class="modal-header">
            <h3>Gán nhân viên vào ca</h3>
            <button class="modal-close" data-modal-close type="button"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="<?= BASE_URL ?>/admin/shifts/assign" class="modal-body">
            <div class="form-group">
                <label class="form-label">Ngày</label>
                <input type="date" name="work_date" class="form-control" value="<?= $today ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Chọn Ca trực</label>
                <select name="shift_id" class="form-control" required>
                    <?php foreach($shifts as $s): ?>
                        <option value="<?= $s['id'] ?>"><?= e($s['name']) ?> (<?= date('H:i', strtotime($s['start_time'])) ?> - <?= date('H:i', strtotime($s['end_time'])) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Chọn Nhân viên</label>
                <select name="user_id" class="form-control" required>
                    <?php foreach($users as $u): ?>
                        <option value="<?= $u['id'] ?>"><?= e($u['name']) ?> - <?= e($u['role']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-gold btn-block btn-lg">Xác nhận gán</button>
        </form>
    </div>
</div>
