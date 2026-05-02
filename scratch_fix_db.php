<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Updating announcements table category column...\n";
    
    // First, let's see what's actually there to be safe
    $columns = DB::select("DESCRIBE announcements");
    foreach ($columns as $column) {
        if ($column->Field === 'category') {
            echo "Current category type: " . $column->Type . "\n";
        }
    }

    // Change to lowercase Indonesian names only. 
    // We avoid mixing cases to prevent "duplicate value" errors on case-insensitive systems.
    DB::statement("ALTER TABLE announcements MODIFY COLUMN category ENUM('mingguan', 'bulanan', 'tahunan') DEFAULT 'mingguan'");
    
    echo "Successfully updated database schema!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    
    // Fallback: If ENUM fails, maybe try VARCHAR(50) first then ENUM?
    try {
        echo "Trying fallback to VARCHAR then ENUM...\n";
        DB::statement("ALTER TABLE announcements MODIFY COLUMN category VARCHAR(50)");
        DB::statement("ALTER TABLE announcements MODIFY COLUMN category ENUM('mingguan', 'bulanan', 'tahunan') DEFAULT 'mingguan'");
        echo "Fallback Success!\n";
    } catch (\Exception $e2) {
        echo "Fallback Error: " . $e2->getMessage() . "\n";
    }
}
