<?php
// ============================================================
// QrTable Model — Aurora Restaurant
// ============================================================

class QrTable extends Model
{
    protected string $table = 'qr_tables';

    public function findByTableId(int $tableId): ?array
    {
        return $this->findOne("SELECT * FROM qr_tables WHERE table_id = ? AND is_active = 1", [$tableId]);
    }

    public function findByToken(string $token): ?array
    {
        return $this->findOne("SELECT * FROM qr_tables WHERE qr_hash = ? AND is_active = 1", [$token]);
    }

    public function incrementScanCount(int $id): void
    {
        $this->execute(
            "UPDATE qr_tables SET scan_count = scan_count + 1, last_scanned_at = NOW() WHERE id = ?",
            [$id]
        );
    }

    public function getAllWithTableInfo(): array
    {
        return $this->findAll(
            "SELECT qr.*, qr.qr_hash as qr_token, t.name as table_name, t.area as table_area 
             FROM qr_tables qr
             JOIN tables t ON qr.table_id = t.id
             ORDER BY t.area, t.sort_order, t.name"
        );
    }

    public function cleanupInvalidTokens(): void
    {
        $allQr = $this->findAll("SELECT id, table_id, qr_hash FROM qr_tables");
        foreach ($allQr as $qr) {
            $h = trim($qr['qr_hash']);
            // Allow 16 (new short) or 32 (old long) hex characters. If anything else, it is garbage.
            if (!in_array(strlen($h), [16, 32]) || !ctype_xdigit($h)) {
                $newToken = bin2hex(random_bytes(8));
                $this->generate($qr['table_id'], $newToken);
            }
        }
    }

    public function markAsPrinted(int $tableId): void
    {
        $this->execute(
            "UPDATE qr_tables SET is_printed = 1 WHERE table_id = ?",
            [$tableId]
        );
    }

    public function generate(int $tableId, string $token): int
    {
        $url = "/qr/menu?table_id=$tableId&token=$token";
        $this->execute(
            "INSERT INTO qr_tables (table_id, qr_hash, qr_code, is_active, is_printed) 
             VALUES (?, ?, ?, 1, 0)
             ON DUPLICATE KEY UPDATE qr_hash = VALUES(qr_hash), qr_code = VALUES(qr_code), is_printed = 0, updated_at = NOW()",
            [$tableId, $token, $url]
        );
        return (int) $this->lastInsertId();
    }
}
