<?php
// ============================================================
// TableStatusHistory Model — Aurora Restaurant
// ============================================================

class TableStatusHistory extends Model
{
    protected string $table = 'table_status_history';

    public function log(int $tableId, string $prevStatus, string $currStatus, ?int $userId, string $reason, ?int $orderId = null): void
    {
        $this->execute(
            "INSERT INTO table_status_history 
             (table_id, previous_status, current_status, changed_by, change_reason, order_id) 
             VALUES (?, ?, ?, ?, ?, ?)",
            [$tableId, $prevStatus, $currStatus, $userId, $reason, $orderId]
        );
    }

    public function getHistoryByTable(int $tableId, int $limit = 10): array
    {
        return $this->findAll(
            "SELECT h.*, u.username as changer_name 
             FROM table_status_history h
             LEFT JOIN users u ON h.changed_by = u.id
             WHERE h.table_id = ?
             ORDER BY h.created_at DESC
             LIMIT ?",
            [$tableId, $limit]
        );
    }
}
