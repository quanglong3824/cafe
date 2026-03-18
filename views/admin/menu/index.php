<?php // views/admin/menu/index.php ?>
<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-utensils"></i> Danh sách Món ăn</h2>
        <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
            <!-- Menu Type Tabs -->
            <a href="<?= BASE_URL ?>/admin/menu" class="btn btn-outline <?= !isset($_GET['type']) || $_GET['type'] === '' ? 'active' : '' ?>">
                <i class="fas fa-utensils"></i> Món Lẻ
            </a>
            <a href="<?= BASE_URL ?>/admin/menu/sets" class="btn btn-outline <?= isset($_GET['type']) && $_GET['type'] === 'sets' ? 'active' : '' ?>">
                <i class="fas fa-layer-group"></i> Set & Combo
            </a>
            
            <!-- Category filter -->
            <select id="catFilter" class="form-control" style="width:auto;min-width:160px;">
                <option value="">Tất cả danh mục</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>">
                        <?= e($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <a href="<?= BASE_URL ?>/admin/menu/create" class="btn btn-gold">
                <i class="fas fa-plus"></i> Thêm món
            </a>
        </div>
    </div>

    <div class="table-wrap">
        <table id="menuTable">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên món</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Tồn kho</th>
                    <th>Hiển thị</th>
                    <th>Còn hàng</th>
                    <th style="width:120px"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr data-cat="<?= $item['category_id'] ?>">
                        <td>
                            <?php if ($item['image']): ?>
                                <img src="<?= BASE_URL ?>/public/uploads/<?= e($item['image']) ?>" alt=""
                                    style="width:44px;height:44px;object-fit:cover;border-radius:6px;">
                            <?php else: ?>
                                <div
                                    style="width:44px;height:44px;background:#f3f4f6;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#9ca3af;">
                                    <i class="fas fa-utensils"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong>
                                <?= e($item['name']) ?>
                            </strong>
                            <?php if ($item['name_en']): ?>
                                <span style="display:block;font-size:.75rem;color:#9ca3af;">
                                    <?= e($item['name_en']) ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= e($item['category_name'] ?? '') ?>
                        </td>
                        <td><strong style="color:var(--gold)">
                                <?= formatPrice($item['price']) ?>
                            </strong></td>
                        <td>
                            <?php if (!isset($item['stock']) || $item['stock'] == -1): ?>
                                <span class="badge" style="background:var(--success);color:#fff">Không giới hạn</span>
                            <?php else: ?>
                                <span class="badge"
                                    style="background:<?= $item['stock'] < 5 ? 'var(--danger)' : 'var(--bg)' ?>;color:<?= $item['stock'] < 5 ? '#fff' : 'var(--text)' ?>">
                                    <?= $item['stock'] ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="toggle-btn <?= $item['is_active'] ? 'toggle-btn--on' : '' ?>"
                                onclick="toggleItem(<?= $item['id'] ?>, 'active', this)"
                                title="<?= $item['is_active'] ? 'Đang hiện — Click để ẩn' : 'Đang ẩn — Click để hiện' ?>">
                                <i class="fas <?= $item['is_active'] ? 'fa-eye' : 'fa-eye-slash' ?>"></i>
                            </button>
                        </td>
                        <td>
                            <button class="toggle-btn <?= $item['is_available'] ? 'toggle-btn--on' : 'toggle-btn--off' ?>"
                                onclick="toggleItem(<?= $item['id'] ?>, 'available', this)"
                                title="<?= $item['is_available'] ? 'Còn hàng — Click để đánh Hết' : 'Hết hàng — Click để Mở lại' ?>">
                                <?= $item['is_available'] ? 'Còn hàng' : 'Hết hàng' ?>
                            </button>
                        </td>
                        <td>
                            <div style="display:flex;gap:.4rem;">
                                <a href="<?= BASE_URL ?>/admin/menu/edit?id=<?= $item['id'] ?>"
                                    class="btn btn-outline btn-sm"><i class="fas fa-pen"></i></a>
                                <form method="POST" action="<?= BASE_URL ?>/admin/menu/delete" style="display:inline">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn btn-danger-outline btn-sm"
                                        data-confirm="Xóa món '<?= e($item['name']) ?>'?">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($items)): ?>
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem;color:#9ca3af">Chưa có món nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Category filter
    document.getElementById('catFilter').addEventListener('change', function () {
        const val = this.value;
        document.querySelectorAll('#menuTable tbody tr[data-cat]').forEach(row => {
            row.style.display = (!val || row.dataset.cat === val) ? '' : 'none';
        });
    });

    function toggleItem(id, type, btn) {
        fetch('<?= BASE_URL ?>/admin/menu/toggle', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ id, type })
        })
            .then(r => r.json())
            .then(data => {
                if (!data.ok) return;
                if (type === 'available') {
                    const on = data.is_available == 1;
                    btn.textContent = on ? 'Còn hàng' : 'Hết hàng';
                    btn.className = 'toggle-btn ' + (on ? 'toggle-btn--on' : 'toggle-btn--off');
                } else {
                    const on = data.is_active == 1;
                    btn.innerHTML = '<i class="fas ' + (on ? 'fa-eye' : 'fa-eye-slash') + '"></i>';
                    btn.className = 'toggle-btn ' + (on ? 'toggle-btn--on' : '');
                    btn.title = on ? 'Đang hiện — Click để ẩn' : 'Đang ẩn — Click để hiện';
                }
            });
    }
</script>