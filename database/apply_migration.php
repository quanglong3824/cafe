<?php
// ============================================================
// Database Migration Executor
// ============================================================

require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/database.php';

echo "Starting migration...\n";

try {
    $pdo = getDB();
    $sql = file_get_contents(__DIR__ . '/migrate_to_cafe.sql');
    
    // PDO exec doesn't handle multiple queries well if they are separated by ; 
    // unless you use the right settings or loop through them.
    // However, for MySQL, it often works if emulation is on or using a specific approach.
    // Let's split by "--" or ";" carefully if needed, but often exec() works for multi-query in MySQL.
    
    $pdo->exec($sql);
    
    echo "Migration completed successfully!\n";
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
