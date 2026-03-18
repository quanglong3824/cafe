<?php
// ============================================================
// CustomerSession Model — Aurora Cafe
// ============================================================

class CustomerSession extends Model
{
    protected string $table = 'customer_sessions';

    public function create(array $data): int
    {
        $this->execute(
            "INSERT INTO customer_sessions 
             (session_id, table_id, order_id, ip_address, user_agent, is_active, expires_at) 
             VALUES (?, ?, ?, ?, ?, 1, ?)
             ON DUPLICATE KEY UPDATE 
             table_id = VALUES(table_id),
             ip_address = VALUES(ip_address),
             user_agent = VALUES(user_agent),
             is_active = 1,
             expires_at = VALUES(expires_at),
             last_activity = NOW()",
            [
                $data['session_id'],
                $data['table_id'],
                $data['order_id'] ?? null,
                $data['ip_address'] ?? $_SERVER['REMOTE_ADDR'],
                $data['user_agent'] ?? $_SERVER['HTTP_USER_AGENT'],
                date('Y-m-d H:i:s', strtotime('+24 hours'))
            ]
        );
        return (int) $this->lastInsertId();
    }

    public function findBySessionId(string $sessionId): ?array
    {
        return $this->findOne(
            "SELECT * FROM customer_sessions WHERE session_id = ? AND is_active = 1 AND (expires_at > NOW() OR expires_at IS NULL)",
            [$sessionId]
        );
    }

    public function updateOrderId(string $sessionId, int $orderId): void
    {
        $this->execute(
            "UPDATE customer_sessions SET order_id = ? WHERE session_id = ?",
            [$orderId, $sessionId]
        );
    }

    public function updateActivity(string $sessionId): void
    {
        $this->execute(
            "UPDATE customer_sessions 
             SET last_activity = NOW(), expires_at = DATE_ADD(NOW(), INTERVAL 24 HOUR) 
             WHERE session_id = ?",
            [$sessionId]
        );
    }

    public function deactivate(string $sessionId): void
    {
        $this->execute(
            "UPDATE customer_sessions SET is_active = 0 WHERE session_id = ?",
            [$sessionId]
        );
    }
}
