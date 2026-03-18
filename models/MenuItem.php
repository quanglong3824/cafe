<?php
// ============================================================
// MenuItem Model — Aurora Restaurant
// ============================================================

class MenuItem extends Model
{
    /** Tất cả món kể cả inactive (admin) */
    public function getAll(): array
    {
        return $this->findAll(
            "SELECT i.*, c.name AS category_name
             FROM menu_items i
             LEFT JOIN menu_categories c ON c.id = i.category_id
             ORDER BY c.sort_order, i.sort_order, i.name"
        );
    }

    /** Tất cả món đang active (không phân biệt type) */
    public function getAllActive(): array
    {
        return $this->findAll(
            "SELECT i.*, c.name AS category_name, c.menu_type
             FROM menu_items i
             LEFT JOIN menu_categories c ON c.id = i.category_id
             WHERE i.is_active = 1
             ORDER BY c.sort_order, i.sort_order, i.name"
        );
    }

    /** Món đang hiển thị, kèm category (waiter), lọc theo menu_type */
    public function getActiveByType(string $type = ''): array
    {
        $where = $type ? "AND c.menu_type = ?" : "";
        $params = $type ? [$type] : [];
        return $this->findAll(
            "SELECT i.*, c.name AS category_name, c.menu_type
             FROM menu_items i
             LEFT JOIN menu_categories c ON c.id = i.category_id
             WHERE i.is_active = 1 {$where}
             ORDER BY c.sort_order, i.sort_order, i.name",
            $params
        );
    }

    /** Nhóm theo category cho waiter menu, có lọc type */
    public function getGroupedByCategory(string $type = ''): array
    {
        $rows = $this->getActiveByType($type);
        $grouped = [];
        foreach ($rows as $row) {
            $cat = $row['category_name'] ?? 'Khác';
            $grouped[$cat][] = $row;
        }
        return $grouped;
    }

    public function findById(int $id): ?array
    {
        return $this->findOne(
            "SELECT i.*, c.name AS category_name
             FROM menu_items i
             LEFT JOIN menu_categories c ON c.id = i.category_id
             WHERE i.id = ?",
            [$id]
        );
    }

    public function create(array $data): int
    {
        $this->execute(
            "INSERT INTO menu_items
             (category_id, name, name_en, description, price, image, is_available, is_active, tags, sort_order)
             VALUES (?, ?, ?, ?, ?, ?, 1, 1, ?, ?)",
            [
                $data['category_id'],
                $data['name'],
                $data['name_en'] ?? null,
                $data['description'] ?? null,
                $data['price'],
                $data['image'] ?? null,
                $data['tags'] ?? null,
                $data['sort_order'] ?? 0,
            ]
        );
        return (int) $this->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $this->execute(
            "UPDATE menu_items
             SET category_id = ?, name = ?, name_en = ?, description = ?,
                 price = ?, tags = ?, sort_order = ?, is_active = ?
             WHERE id = ?",
            [
                $data['category_id'],
                $data['name'],
                $data['name_en'] ?? null,
                $data['description'] ?? null,
                $data['price'],
                $data['tags'] ?? null,
                $data['sort_order'] ?? 0,
                $data['is_active'] ?? 1,
                $id,
            ]
        );
    }

    public function updateImage(int $id, string $image): void
    {
        $this->execute("UPDATE menu_items SET image = ? WHERE id = ?", [$image, $id]);
    }

    /** Toggle hết hàng / còn hàng */
    public function toggleAvailable(int $id): void
    {
        $this->execute(
            "UPDATE menu_items SET is_available = NOT is_available WHERE id = ?",
            [$id]
        );
    }

    /** Toggle hiển thị / ẩn */
    public function toggleActive(int $id): void
    {
        $this->execute(
            "UPDATE menu_items SET is_active = NOT is_active WHERE id = ?",
            [$id]
        );
    }

    public function delete(int $id): void
    {
        $this->execute("DELETE FROM menu_items WHERE id = ?", [$id]);
    }

    /** Top món được gọi nhiều nhất */
    public function getTopItems(int $limit = 10, string $from = '', string $to = ''): array
    {
        $where = '';
        $params = [];
        if ($from && $to) {
            $where = "AND DATE(o.opened_at) BETWEEN ? AND ?";
            $params = [$from, $to];
        }
        return $this->findAll(
            "SELECT i.name, SUM(oi.quantity) AS total_qty
             FROM order_items oi
             JOIN menu_items i ON i.id = oi.menu_item_id
             JOIN orders o ON o.id = oi.order_id
             WHERE 1=1 {$where}
             GROUP BY oi.menu_item_id
             ORDER BY total_qty DESC
             LIMIT ?",
            array_merge($params, [$limit])
        );
    }

    /** Add gallery image for menu item (placeholder for future gallery feature) */
    public function addGalleryImage(int $itemId, string $imagePath): bool
    {
        // Placeholder: Gallery feature not fully implemented yet
        // This method can be extended to store multiple images per menu item
        return true;
    }
}
