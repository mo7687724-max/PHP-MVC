<?php

require_once __DIR__ . '/../app/Core/Database.php';

try {
    echo "Running migrations...\n";

    $db = Database::connection();

    $migrationFiles = glob(__DIR__ . '/migrations/*.php');
    sort($migrationFiles);

    foreach ($migrationFiles as $file) {
        $migrationName = basename($file);
        echo "Migrating: $migrationName\n";

        $migration = require $file;
        if (isset($migration['up'])) {
            $db->exec($migration['up']);
            echo "Migrated:  $migrationName\n";
        }
    }

    echo "All migrations completed successfully.\n";
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}

