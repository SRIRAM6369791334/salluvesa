<?php
// PHP Script to generate DATABASE_SCHEMA_SAALUVESA.md for dash/saaluvesa_db

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

try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $tablesStmt = $pdo->query("SHOW TABLES");
    $tables = $tablesStmt->fetchAll(PDO::FETCH_COLUMN);

    $md = "# 🗄️ Database Schema Documentation: `{$dbname}`\n\n";
    $md .= "**Host**: `{$host}` | **Generated At**: " . date('Y-m-d H:i:s') . " | **Total Tables**: " . count($tables) . "\n\n";
    $md .= "---\n\n## 📌 Table List & Row Counts\n\n";
    $md .= "| Table Name | Row Count |\n| :--- | :--- |\n";

    $tablesData = [];

    foreach ($tables as $table) {
        $countStmt = $pdo->query("SELECT COUNT(*) FROM `{$table}`");
        $rowCount = $countStmt->fetchColumn();
        $md .= "| `{$table}` | {$rowCount} |\n";

        $colsStmt = $pdo->query("SHOW COLUMNS FROM `{$table}`");
        $tablesData[$table] = [
            'count' => $rowCount,
            'columns' => $colsStmt->fetchAll()
        ];
    }

    $md .= "\n---\n\n## 📋 Detailed Table Structures\n\n";

    foreach ($tablesData as $table => $data) {
        $md .= "### 🗂️ Table: `{$table}` (Rows: {$data['count']})\n\n";
        $md .= "| Column Name | Type | Nullable | Key | Default |\n";
        $md .= "| :--- | :--- | :--- | :--- | :--- |\n";

        foreach ($data['columns'] as $col) {
            $default = $col['Default'] === null ? '*NULL*' : "`{$col['Default']}`";
            $key = $col['Key'] ? "**{$col['Key']}**" : "-";
            $md .= "| `{$col['Field']}` | `{$col['Type']}` | {$col['Null']} | {$key} | {$default} |\n";
        }
        $md .= "\n---\n\n";
    }

    file_put_contents(__DIR__ . '/DATABASE_SCHEMA_SAALUVESA.md', $md);
    echo "Successfully generated DATABASE_SCHEMA_SAALUVESA.md with " . count($tables) . " tables.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
