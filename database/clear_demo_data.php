<?php
// ============================================================
// Clear Demo Transactional Data
// Chừa lại Users và Menu để Demo
// ============================================================

require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/database.php';

echo "Starting to clear transactional data for Cafe demo...\n";

try {
    $pdo = getDB();
    
    // Disable foreign key checks to truncate safely
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    
    $tablesToClear = [
        'customer_sessions',
        'orders',
        'order_items',
        'order_notifications',
        'table_status_history',
        'supports'
    ];
    
    foreach ($tablesToClear as $table) {
        echo "Clearing table: {$table}...\n";
        $pdo->exec("TRUNCATE TABLE `{$table}`;");
    }
    
    // Reset table statuses to available
    echo "Resetting all tables to available status...\n";
    $pdo->exec("UPDATE `tables` SET `status` = 'available';");
    
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
    
    echo "\nSuccess: Transactional data cleared. Users and Menu items are preserved.\n";
    echo "You can now delete this file (database/clear_demo_data.php) for security.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
