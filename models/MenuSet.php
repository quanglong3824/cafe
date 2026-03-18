<?php
// ============================================================
// MenuSet Model — Aurora Restaurant (À la carte sets)
// ============================================================

class MenuSet extends Model
{
    protected string $table = 'menu_sets';

    /** Lấy tất cả sets */
    public function getAll(): array
    {
        return $this->findAll(
            "SELECT * FROM menu_sets ORDER BY sort_order, name"
        );
    }

    /** Lấy sets đang active */
    public function getActive(): array
    {
        return $this->findAll(
            "SELECT * FROM menu_sets WHERE is_active = 1 ORDER BY sort_order, name"
        );
    }

    public function findById(int $id): ?array
    {
        return $this->findOne("SELECT * FROM menu_sets WHERE id = ?", [$id]);
    }

    /** Lấy các món trong set */
    public function getSetItems(int $setId): array
    {
        return $this->findAll(
            "SELECT si.*, mi.name, mi.price, mi.image
             FROM menu_set_items si
             JOIN menu_items mi ON mi.id = si.menu_item_id
             WHERE si.set_id = ?
             ORDER BY si.is_required DESC, si.sort_order, mi.name",
            [$setId]
        );
    }

    public function create(array $data): int
    {
        $this->execute(
            "INSERT INTO menu_sets (name, name_en, description, price, image, is_active, sort_order)
             VALUES (?, ?, ?, ?, ?, 1, ?)",
            [
                $data['name'],
                $data['name_en'] ?? null,
                $data['description'] ?? null,
                $data['price'],
                $data['image'] ?? null,
                $data['sort_order'] ?? 0,
            ]
        );
        return (int) $this->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $this->execute(
            "UPDATE menu_sets
             SET name = ?, name_en = ?, description = ?, price = ?, image = ?,
                 is_active = ?, sort_order = ?
             WHERE id = ?",
            [
                $data['name'],
                $data['name_en'] ?? null,
                $data['description'] ?? null,
                $data['price'],
                $data['image'] ?? null,
                $data['is_active'] ?? 1,
                $data['sort_order'] ?? 0,
                $id,
            ]
        );
    }

    /** Thêm món vào set */
    public function addItem(int $setId, int $menuItemId, int $qty = 1, bool $isRequired = true, int $sortOrder = 0): void
    {
        $this->execute(
            "INSERT INTO menu_set_items (set_id, menu_item_id, quantity, is_required, sort_order)
             VALUES (?, ?, ?, ?, ?)",
            [$setId, $menuItemId, $qty, $isRequired ? 1 : 0, $sortOrder]
        );
    }

    /** Xóa món khỏi set */
    public function removeItem(int $setId, int $menuItemId): void
    {
        $this->execute(
            "DELETE FROM menu_set_items WHERE set_id = ? AND menu_item_id = ?",
            [$setId, $menuItemId]
        );
    }

    /** Cập nhật món trong set */
    public function updateItem(int $setId, int $menuItemId, array $data): void
    {
        $this->execute(
            "UPDATE menu_set_items
             SET quantity = ?, is_required = ?, sort_order = ?
             WHERE set_id = ? AND menu_item_id = ?",
            [
                $data['quantity'] ?? 1,
                ($data['is_required'] ?? true) ? 1 : 0,
                $data['sort_order'] ?? 0,
                $setId,
                $menuItemId,
            ]
        );
    }

    public function delete(int $id): void
    {
        $this->execute("DELETE FROM menu_sets WHERE id = ?", [$id]);
    }

    public function toggleActive(int $id): void
    {
        $this->execute("UPDATE menu_sets SET is_active = NOT is_active WHERE id = ?", [$id]);
    }

    public function removeAllItems(int $setId): void
    {
        $this->execute("DELETE FROM menu_set_items WHERE set_id = ?", [$setId]);
    }
}
