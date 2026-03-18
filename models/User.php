<?php
// ============================================================
// User Model — Aurora Restaurant
// ============================================================

class User extends Model
{
    protected string $table = 'users';

    /**
     * Tìm user theo username + PIN
     */
    public function findByCredentials(string $username, string $pin): ?array
    {
        return $this->findOne(
            "SELECT * FROM users WHERE username = ? AND pin = ? AND is_active = 1 LIMIT 1",
            [$username, $pin]
        );
    }

    /**
     * Lấy danh sách nhân viên đang hoạt động (để hiển thị nhanh trên màn login iPad)
     */
    public function getActiveStaff(): array
    {
        return $this->findAll(
            "SELECT id, name, username, role FROM users WHERE is_active = 1 ORDER BY role DESC, name ASC"
        );
    }

    /**
     * Tìm user theo ID
     */
    public function findById(int $id): ?array
    {
        return $this->findOne(
            "SELECT id, name, username, pin, role, is_active FROM users WHERE id = ?",
            [$id]
        );
    }

    /**
     * Lấy tất cả user (IT quản lý)
     */
    public function getAll(): array
    {
        return $this->findAll(
            "SELECT id, name, username, role, is_active, created_at FROM users ORDER BY role, name"
        );
    }

    /**
     * Tạo user mới
     */
    public function create(array $data): int
    {
        $this->execute(
            "INSERT INTO users (name, username, pin, role, is_active) VALUES (?, ?, ?, ?, 1)",
            [$data['name'], $data['username'], $data['pin'], $data['role']]
        );
        return (int) $this->lastInsertId();
    }

    /**
     * Cập nhật user
     */
    public function update(int $id, array $data): void
    {
        $this->execute(
            "UPDATE users SET name = ?, username = ?, pin = ?, role = ?, is_active = ? WHERE id = ?",
            [$data['name'], $data['username'], $data['pin'], $data['role'], $data['is_active'], $id]
        );
    }

    /**
     * Xóa user
     */
    public function delete(int $id): void
    {
        $this->execute("DELETE FROM users WHERE id = ?", [$id]);
    }
}
