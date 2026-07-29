<?php
// PHP Script to inspect all tables and columns in saaluvesa_db (dash)

$host = '127.0.0.1';
$user = 'root';
$pass = '';
$dbname = 'saaluvesa_db';

// Try reading .env file if available
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim(trim($value), '"\'');
            if ($name === 'DB_HOST') $host = $value;
            if ($name === 'DB_USERNAME') $user = $value;
            if ($name === 'DB_PASSWORD') $pass = $value;
            if ($name === 'DB_DATABASE') $dbname = $value;
        }
    }
}

echo "=== DATABASE INSPECTION REPORT FOR: {$dbname} ===\n\n";

try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $tablesStmt = $pdo->query("SHOW TABLES");
    $tables = $tablesStmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Found " . count($tables) . " tables in database '{$dbname}':\n";
    echo implode(", ", $tables) . "\n\n";

    echo "====================================================\n";
    echo "DETAILED TABLE STRUCTURES & COLUMNS\n";
    echo "====================================================\n\n";

    foreach ($tables as $table) {
        echo "### Table: `{$table}`\n";
        
        $countStmt = $pdo->query("SELECT COUNT(*) FROM `{$table}`");
        $rowCount = $countStmt->fetchColumn();
        echo "Total Rows: {$rowCount}\n";

        $colsStmt = $pdo->query("SHOW COLUMNS FROM `{$table}`");
        $columns = $colsStmt->fetchAll();

        echo str_pad("Column Name", 30) . str_pad("Type", 25) . str_pad("Null", 8) . str_pad("Key", 8) . "Default\n";
        echo str_repeat("-", 80) . "\n";
        foreach ($columns as $col) {
            $name = str_pad($col['Field'], 30);
            $type = str_pad($col['Type'], 25);
            $null = str_pad($col['Null'], 8);
            $key  = str_pad($col['Key'], 8);
            $default = $col['Default'] === null ? 'NULL' : $col['Default'];
            echo "{$name}{$type}{$null}{$key}{$default}\n";
        }
        echo "\n" . str_repeat("=", 80) . "\n\n";
    }

} catch (PDOException $e) {
    echo "Error connecting to database: " . $e->getMessage() . "\n";
}
