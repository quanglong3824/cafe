<?php // views/admin/categories/index.php ?>
<div class="content-with-aside content-with-aside--sm">

    <!-- Category list -->
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-tags"></i> Danh Mục Món</h2>
            <span class="badge badge-gold"><?= count($categories) ?> danh mục</span>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Phân loại</th>
                        <th>Tên VI</th>
                        <th>Tên EN</th>
                        <th>Thứ tự</th>
                        <th>Trạng thái</th>
                        <th style="width:120px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td>
                                <i class="fas <?= e($cat['icon'] ?? 'fa-coffee') ?>"
                                    style="color:var(--gold);font-size:1.1rem;"></i>
                            </td>
                            <td>
                                <?php 
                                    $types = ['asia' => 'Á', 'europe' => 'Âu', 'alacarte' => 'Ala Carte', 'other' => 'Khác'];
                                    echo $types[$cat['menu_type']] ?? 'Á';
                                ?>
                            </td>
                            <td><strong><?= e($cat['name']) ?></strong></td>
                            <td style="color:#9ca3af;"><?= e($cat['name_en'] ?? '') ?></td>
                            <td><?= $cat['sort_order'] ?></td>
                            <td>
                                <span class="badge <?= $cat['is_active'] ? 'badge-success' : 'badge-danger' ?>">
                                    <?= $cat['is_active'] ? 'Hiện' : 'Ẩn' ?>
                                </span>
                            </td>
                            <td>
                                <div style="display:flex;gap:.4rem;">
                                    <a href="<?= BASE_URL ?>/admin/categories/edit?id=<?= $cat['id'] ?>"
                                        class="btn btn-outline btn-sm" title="Sửa">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form method="POST" action="<?= BASE_URL ?>/admin/categories/delete"
                                        style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                                        <button type="submit" class="btn btn-danger-outline btn-sm"
                                            data-confirm="Xóa danh mục '<?= e($cat['name']) ?>'?" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($categories)): ?>
                        <tr>
                            <td colspan="6" style="text-align:center;padding:2rem;color:#9ca3af;">
                                Chưa có danh mục nào.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add / Edit form (sticky aside) -->
    <div class="card sticky-aside">
        <?php if ($editItem): ?>
            <!-- Edit mode -->
            <div class="card-header">
                <h2><i class="fas fa-pen"></i> Sửa Danh Mục</h2>
                <a href="<?= BASE_URL ?>/admin/categories" class="btn btn-outline btn-sm">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/admin/categories/update">
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">

                <div class="form-group">
                    <label class="form-label">Tên (VI) *</label>
                    <input type="text" name="name" class="form-control" required value="<?= e($editItem['name']) ?>"
                        placeholder="VD: Khai Vị">
                </div>
                <div class="form-group">
                    <label class="form-label">Tên (EN)</label>
                    <input type="text" name="name_en" class="form-control" value="<?= e($editItem['name_en'] ?? '') ?>"
                        placeholder="VD: Appetizers">
                </div>
                <div class="form-group">
                    <label class="form-label">Phân loại Menu</label>
                    <select name="menu_type" class="form-control">
                        <option value="asia" <?= $editItem['menu_type'] === 'asia' ? 'selected' : '' ?>>Á</option>
                        <option value="europe" <?= $editItem['menu_type'] === 'europe' ? 'selected' : '' ?>>Âu</option>
                        <option value="alacarte" <?= $editItem['menu_type'] === 'alacarte' ? 'selected' : '' ?>>Ala Carte</option>
                        <option value="other" <?= $editItem['menu_type'] === 'other' ? 'selected' : '' ?>>Khác</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Icon (Font Awesome)</label>
                    <input type="text" name="icon" class="form-control" value="<?= e($editItem['icon'] ?? 'fa-coffee') ?>"
                        placeholder="fa-coffee">
                    <p class="form-hint">Xem icon tại <a href="https://fontawesome.com/icons" target="_blank"
                            rel="noopener">fontawesome.com</a></p>
                </div>
                <div class="form-group">
                    <label class="form-label">Thứ tự</label>
                    <input type="number" name="sort_order" class="form-control" min="0"
                        value="<?= (int) $editItem['sort_order'] ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Trạng thái</label>
                    <select name="is_active" class="form-control">
                        <option value="1" <?= $editItem['is_active'] ? 'selected' : '' ?>>Hiện</option>
                        <option value="0" <?= !$editItem['is_active'] ? 'selected' : '' ?>>Ẩn</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-gold btn-block">
                    <i class="fas fa-save"></i> Lưu thay đổi
                </button>
            </form>

        <?php else: ?>
            <!-- Add mode -->
            <div class="card-header">
                <h2><i class="fas fa-plus"></i> Thêm Danh Mục</h2>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/admin/categories/store">
                <div class="form-group">
                    <label class="form-label">Tên (VI) *</label>
                    <input type="text" name="name" class="form-control" required placeholder="VD: Khai Vị">
                </div>
                <div class="form-group">
                    <label class="form-label">Tên (EN)</label>
                    <input type="text" name="name_en" class="form-control" placeholder="VD: Appetizers">
                </div>
                <div class="form-group">
                    <label class="form-label">Phân loại Menu</label>
                    <select name="menu_type" class="form-control">
                        <option value="asia">Á</option>
                        <option value="europe">Âu</option>
                        <option value="alacarte">Ala Carte</option>
                        <option value="other">Khác</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Icon (Font Awesome)</label>
                    <input type="text" name="icon" class="form-control" value="fa-coffee" placeholder="fa-coffee">
                    <p class="form-hint">Xem icon tại <a href="https://fontawesome.com/icons" target="_blank"
                            rel="noopener">fontawesome.com</a></p>
                </div>
                <div class="form-group">
                    <label class="form-label">Thứ tự</label>
                    <input type="number" name="sort_order" class="form-control" value="0" min="0">
                </div>
                <button type="submit" class="btn btn-gold btn-block">
                    <i class="fas fa-save"></i> Lưu danh mục
                </button>
            </form>
        <?php endif; ?>
    </div>

</div>