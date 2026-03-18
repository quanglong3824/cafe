<?php // views/admin/menu/sets.php — Manage Sets & Combos ?>
<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-coffee"></i> Danh sách Set & Combo</h2>
        <button class="btn btn-gold" onclick="openAddSetModal()">
            <i class="fas fa-plus"></i> Thêm Set Mới
        </button>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên Set</th>
                    <th>Giá</th>
                    <th>Món trong Set</th>
                    <th>Hiển thị</th>
                    <th style="width: 120px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sets as $set): ?>
                    <tr>
                        <td>
                            <?php if ($set['image']): ?>
                                <img src="<?= BASE_URL ?>/public/uploads/<?= e($set['image']) ?>" alt=""
                                    style="width: 44px; height: 44px; object-fit: cover; border-radius: 6px;">
                            <?php else: ?>
                                <div style="width: 44px; height: 44px; background: #f3f4f6; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                    <i class="fas fa-coffee"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?= e($set['name']) ?></strong>
                            <?php if ($set['name_en']): ?>
                                <span style="display: block; font-size: 0.75rem; color: #9ca3af;"><?= e($set['name_en']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td><strong style="color: var(--gold)"><?= formatPrice($set['price']) ?></strong></td>
                        <td>
                            <div style="display: flex; flex-wrap: wrap; gap: 0.25rem;">
                                <?php foreach ($set['items'] ?? [] as $item): ?>
                                    <span class="badge" style="background: var(--bg); font-size: 0.75rem;">
                                        <?= e($item['name']) ?> x<?= $item['quantity'] ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td>
                            <button class="toggle-btn <?= $set['is_active'] ? 'toggle-btn--on' : '' ?>"
                                onclick="toggleSet(<?= $set['id'] ?>, this)"
                                title="<?= $set['is_active'] ? 'Đang hiện — Click để ẩn' : 'Đang ẩn — Click để hiện' ?>">
                                <i class="fas <?= $set['is_active'] ? 'fa-eye' : 'fa-eye-slash' ?>"></i>
                            </button>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.4rem;">
                                <button onclick="editSet(<?= htmlspecialchars(json_encode($set)) ?>)" 
                                    class="btn btn-outline btn-sm"><i class="fas fa-pen"></i></button>
                                <form method="POST" action="<?= BASE_URL ?>/admin/menu/sets/delete" style="display: inline">
                                    <input type="hidden" name="id" value="<?= $set['id'] ?>">
                                    <button type="submit" class="btn btn-danger-outline btn-sm"
                                        data-confirm="Xóa set '<?= e($set['name']) ?>'?">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add/Edit Set -->
<div class="modal-backdrop" id="setModal">
    <div class="modal" style="max-width: 700px;">
        <div class="modal-header">
            <h3 id="modalTitle">Thêm Set Mới</h3>
            <button class="modal-close" data-modal-close type="button"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="<?= BASE_URL ?>/admin/menu/sets/store" id="setForm" class="modal-body">
            <input type="hidden" name="id" id="setId">
            
            <div class="form-group">
                <label class="form-label">Tên Set *</label>
                <input type="text" name="name" id="setName" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Tên Tiếng Anh</label>
                <input type="text" name="name_en" id="setNameEn" class="form-control">
            </div>
            
            <div class="form-group">
                <label class="form-label">Giá (VNĐ) *</label>
                <input type="number" name="price" id="setPrice" class="form-control" required min="0">
            </div>
            
            <div class="form-group">
                <label class="form-label">Mô tả</label>
                <textarea name="description" id="setDescription" class="form-control" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-plus"></i> Thêm Món vào Set</label>
                <div id="setItemsContainer" style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <!-- Items will be added here dynamically -->
                </div>
                <button type="button" onclick="addSetItemRow()" class="btn btn-outline btn-sm" style="margin-top: 0.5rem;">
                    <i class="fas fa-plus"></i> Thêm Món
                </button>
            </div>
            
            <div style="display: flex; gap: 0.5rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-gold btn-block">
                    <i class="fas fa-save"></i> Lưu Set
                </button>
                <button type="button" class="btn btn-ghost" data-modal-close>Hủy</button>
            </div>
        </form>
    </div>
</div>

<!-- Template for item row -->
<template id="itemRowTemplate">
    <div class="set-item-row" style="display: flex; gap: 0.5rem; align-items: center;">
        <select name="item_ids[]" class="form-control" style="flex: 2;" required>
            <option value="">-- Chọn món --</option>
            <?php 
            $allItems = (new MenuItem())->getAll();
            foreach ($allItems as $item): 
            ?>
                <option value="<?= $item['id'] ?>"><?= e($item['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="quantities[]" class="form-control" value="1" min="1" style="width: 80px;" placeholder="SL">
        <label style="display: flex; align-items: center; gap: 0.25rem; font-size: 0.85rem; white-space: nowrap;">
            <input type="checkbox" name="is_required[]" value="1" checked> Bắt buộc
        </label>
        <button type="button" onclick="this.closest('.set-item-row').remove()" class="btn btn-danger-outline btn-sm">
            <i class="fas fa-times"></i>
        </button>
    </div>
</template>

<script>
function openAddSetModal() {
    document.getElementById('modalTitle').textContent = 'Thêm Set Mới';
    document.getElementById('setForm').action = '<?= BASE_URL ?>/admin/menu/sets/store';
    document.getElementById('setId').value = '';
    document.getElementById('setName').value = '';
    document.getElementById('setNameEn').value = '';
    document.getElementById('setPrice').value = '';
    document.getElementById('setDescription').value = '';
    document.getElementById('setItemsContainer').innerHTML = '';
    Aurora.openModal('setModal');
}

function editSet(set) {
    document.getElementById('modalTitle').textContent = 'Sửa Set';
    document.getElementById('setForm').action = '<?= BASE_URL ?>/admin/menu/sets/update';
    document.getElementById('setId').value = set.id;
    document.getElementById('setName').value = set.name;
    document.getElementById('setNameEn').value = set.name_en || '';
    document.getElementById('setPrice').value = set.price;
    document.getElementById('setDescription').value = set.description || '';
    
    // Clear and add existing items
    document.getElementById('setItemsContainer').innerHTML = '';
    if (set.items && set.items.length > 0) {
        set.items.forEach(item => {
            addSetItemRow(item.id, item.quantity, item.is_required);
        });
    }
    
    Aurora.openModal('setModal');
}

function addSetItemRow(selectedId = '', qty = 1, isRequired = true) {
    const template = document.getElementById('itemRowTemplate');
    const clone = template.content.cloneNode(true);
    
    if (selectedId) {
        const select = clone.querySelector('select[name="item_ids[]"]');
        select.value = selectedId;
    }
    
    if (qty) {
        clone.querySelector('input[name="quantities[]"]').value = qty;
    }
    
    if (!isRequired) {
        clone.querySelector('input[name="is_required[]"]').checked = false;
    }
    
    document.getElementById('setItemsContainer').appendChild(clone);
}

function toggleSet(id, btn) {
    const data = new FormData();
    data.append('id', id);
    
    fetch('<?= BASE_URL ?>/admin/menu/sets/toggle', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(res => {
        if (res.ok) {
            btn.classList.toggle('toggle-btn--on');
            const icon = btn.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    });
}

// Add initial item row when opening modal
document.querySelectorAll('[data-modal-open]').forEach(btn => {
    btn.addEventListener('click', () => {
        addSetItemRow();
    });
});
</script>
