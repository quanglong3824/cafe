<?php // views/it/users.php ?>
<div class="content-with-aside">

    <!-- User list -->
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-users"></i> Nhân viên hệ thống</h2>
            <span class="badge badge-gold"><?= count($users) ?> tài khoản</span>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Họ tên</th>
                        <th>Username</th>
                        <th>Vai trò</th>
                        <th class="table-hide-sm">Trạng thái</th>
                        <th style="width:110px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr <?= $editUser && $editUser['id'] == $u['id'] ? 'style="background:rgba(212,175,55,.06);"' : '' ?>>
                            <td>
                                <div class="user-cell">
                                    <div class="avatar-initials">
                                        <?= strtoupper(mb_substr($u['name'], 0, 1)) ?>
                                    </div>
                                    <?= e($u['name']) ?>
                                    <?php if ($u['id'] === Auth::user()['id']): ?>
                                        <span class="badge badge-info" style="font-size:.65rem;">Bạn</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td><code class="chip"><?= e($u['username']) ?></code></td>
                            <td>
                                <?php $roleColors = ['waiter' => 'badge-info', 'admin' => 'badge-gold', 'it' => 'badge-warning']; ?>
                                <span class="badge <?= $roleColors[$u['role']] ?? 'badge-info' ?>">
                                    <?= roleLabel($u['role']) ?>
                                </span>
                            </td>
                            <td class="table-hide-sm">
                                <span class="badge <?= $u['is_active'] ? 'badge-success' : 'badge-danger' ?>">
                                    <?= $u['is_active'] ? 'Hoạt động' : 'Khoá' ?>
                                </span>
                            </td>
                            <td>
                                <div style="display:flex;gap:.4rem;align-items:center;">
                                    <a href="<?= BASE_URL ?>/it/users/edit?id=<?= $u['id'] ?>"
                                        class="btn btn-outline btn-sm" title="Sửa">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <?php if ($u['id'] !== Auth::user()['id']): ?>
                                        <form method="POST" action="<?= BASE_URL ?>/it/users/delete" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                            <button type="submit" class="btn btn-danger-outline btn-sm"
                                                data-confirm="Xóa tài khoản '<?= e($u['name']) ?>'?">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add / Edit user form -->
    <div class="card sticky-aside">
        <?php if ($editUser): ?>
            <!-- Edit mode -->
            <div class="card-header">
                <h2><i class="fas fa-user-pen"></i> Sửa Nhân viên</h2>
                <a href="<?= BASE_URL ?>/it/users" class="btn btn-outline btn-sm">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/it/users/update" autocomplete="off">
                <input type="hidden" name="id" value="<?= $editUser['id'] ?>">

                <div class="form-group">
                    <label class="form-label">Họ tên *</label>
                    <input type="text" name="name" class="form-control" required value="<?= e($editUser['name']) ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Username *</label>
                    <input type="text" name="username" class="form-control" required value="<?= e($editUser['username']) ?>"
                        pattern="[a-z0-9_]{3,20}" title="Chữ thường, số, gạch dưới (3–20 ký tự)">
                    <p class="form-hint">Chữ thường, số, gạch dưới.</p>
                </div>
                <div class="form-group">
                    <label class="form-label">PIN mới (4 số)</label>
                    <input type="password" name="pin" class="form-control" inputmode="numeric" maxlength="4" minlength="4"
                        pattern="\d{4}" placeholder="••••  (để trống = giữ nguyên)">
                    <p class="form-hint">Để trống để giữ PIN cũ.</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Vai trò *</label>
                    <select name="role" class="form-control">
                        <option value="waiter" <?= $editUser['role'] === 'waiter' ? 'selected' : '' ?>>Phục vụ</option>
                        <option value="admin" <?= $editUser['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="it" <?= $editUser['role'] === 'it' ? 'selected' : '' ?>>IT</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Trạng thái</label>
                    <select name="is_active" class="form-control" <?= $editUser['id'] === Auth::user()['id'] ? 'disabled' : '' ?>>
                        <option value="1" <?= $editUser['is_active'] ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="0" <?= !$editUser['is_active'] ? 'selected' : '' ?>>Khoá</option>
                    </select>
                    <?php if ($editUser['id'] === Auth::user()['id']): ?>
                        <p class="form-hint">Không thể khoá tài khoản đang đăng nhập.</p>
                        <input type="hidden" name="is_active" value="1">
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-gold btn-block">
                    <i class="fas fa-save"></i> Lưu thay đổi
                </button>
            </form>

        <?php else: ?>
            <!-- Add mode -->
            <div class="card-header">
                <h2><i class="fas fa-user-plus"></i> Thêm Nhân viên</h2>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/it/users/store" autocomplete="off">
                <div class="form-group">
                    <label class="form-label">Họ tên *</label>
                    <input type="text" name="name" class="form-control" required placeholder="VD: Nguyễn Văn A">
                </div>
                <div class="form-group">
                    <label class="form-label">Username *</label>
                    <input type="text" name="username" class="form-control" required autocomplete="username"
                        placeholder="VD: waiter03" pattern="[a-z0-9_]{3,20}" title="Chữ thường, số, gạch dưới (3–20 ký tự)">
                    <p class="form-hint">Chữ thường, số, gạch dưới. 3–20 ký tự.</p>
                </div>
                <div class="form-group">
                    <label class="form-label">PIN (4 số) *</label>
                    <input type="password" name="pin" class="form-control" required inputmode="numeric" maxlength="4"
                        minlength="4" pattern="\d{4}" title="Đúng 4 chữ số" placeholder="••••">
                </div>
                <div class="form-group">
                    <label class="form-label">Vai trò *</label>
                    <select name="role" class="form-control">
                        <option value="waiter">Phục vụ</option>
                        <option value="admin">Admin nhà hàng</option>
                        <option value="it">IT</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-gold btn-block">
                    <i class="fas fa-save"></i> Thêm nhân viên
                </button>
            </form>
        <?php endif; ?>
    </div>

</div>