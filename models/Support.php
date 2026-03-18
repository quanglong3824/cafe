<?php
// ============================================================
// Support Model — Aurora Restaurant
// ============================================================

class Support extends Model
{
    public function createRequest(int $tableId, string $type): int
    {
        // Chống spam: Nếu cùng một bàn gửi yêu cầu cùng loại trong 2 phút qua
        $existing = $this->findOne(
            "SELECT id FROM support_requests 
             WHERE table_id = ? AND type = ? AND status = 'pending' 
             AND created_at >= NOW() - INTERVAL 2 MINUTE",
            [$tableId, $type]
        );

        if ($existing) {
            return (int)$existing['id'];
        }

        $this->execute(
            "INSERT INTO support_requests (table_id, type, status) VALUES (?, ?, 'pending')",
            [$tableId, $type]
        );
        return (int) $this->lastInsertId();
    }

    /** Tìm các yêu cầu đang chờ (dành cho logic nghiệp vụ khác) */
    public function getPendingByTable(int $tableId): array
    {
        return $this->findAll(
            "SELECT * FROM support_requests WHERE table_id = ? AND status = 'pending'",
            [$tableId]
        );
    }

    /** Đánh dấu đã xử lý theo bàn và loại */
    public function resolveByTableAndType(int $tableId, string $type): void
    {
        // Map notification_type to support_request type if needed
        $internalType = $type;
        if ($type === 'payment_request') $internalType = 'payment';
        if ($type === 'support_request') $internalType = 'support';

        $this->execute(
            "UPDATE support_requests SET status = 'completed', updated_at = NOW() 
             WHERE table_id = ? AND type = ? AND status = 'pending'",
            [$tableId, $internalType]
        );
    }

    /** Đánh dấu hoàn thành theo ID cụ thể (có tiền tố) */
    public function resolveRequest(string $prefixedId): void
    {
        if (strpos($prefixedId, 'sr_') === 0) {
            $id = (int)str_replace('sr_', '', $prefixedId);
            $this->execute("UPDATE support_requests SET status = 'completed' WHERE id = ?", [$id]);
        }
    }
}
