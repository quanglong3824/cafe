<?php
// ============================================================
// Cafe Migration Executor (Direct SQL)
// ============================================================

require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/database.php';

echo "Starting migration via PHP PDO...\n";

try {
    $pdo = getDB();
    $sqlFile = __DIR__ . '/migrate_to_cafe.sql';
    if (!file_exists($sqlFile)) {
        die("Migration SQL file not found!\n");
    }
    
    $sql = file_get_contents($sqlFile);
    
    // Split SQL by semicolon, but careful with triggers/stored procedures if any
    // For this simple script, splitting by ; is usually enough
    $queries = array_filter(array_map('trim', explode(';', $sql)));
    
    foreach ($queries as $query) {
        if (!empty($query)) {
            $pdo->exec($query);
        }
    }
    
    echo "Migration completed successfully! Menu is now Cafe-ready.\n";
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
unlink(__FILE__); // Xóa tệp này sau khi chạy xong để bảo mật
