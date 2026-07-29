<?php
/**
 * Database Schema Report Generator
 * Connects via PDO using .env credentials, dumps full schema to Markdown
 */

$basePath = realpath(__DIR__ . '/..');
$outputFile = __DIR__ . '/db-schema-report.md';

// Try loading .env from dash or web
$envFiles = [
    $basePath . '/dash/.env',
    $basePath . '/web/.env',
];

$envVars = [];
foreach ($envFiles as $envFile) {
    if (!file_exists($envFile)) continue;
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) continue;
        if (strpos($line, '=') === false) continue;
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        $value = trim($value, "'\"");
        $envVars[$key] = $value;
    }
    if (!empty($envVars['DB_DATABASE'])) break;
}

$host = $envVars['DB_HOST'] ?? '127.0.0.1';
$port = $envVars['DB_PORT'] ?? '3306';
$dbname = $envVars['DB_DATABASE'] ?? '';
$username = $envVars['DB_USERNAME'] ?? 'root';
$password = $envVars['DB_PASSWORD'] ?? '';

if (empty($dbname)) {
    die("ERROR: Could not determine database name from .env files.\n");
}

echo "Connecting to: $host:$port / $dbname as $username\n";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "Connected successfully.\n";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage() . "\n");
}

// Get all tables
$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
sort($tables);
echo "Found " . count($tables) . " tables.\n";

// Start building markdown
$md = "# Database Schema Report\n\n";
$md .= "**Generated:** " . date('Y-m-d H:i:s') . "\n";
$md .= "**Database:** `$dbname`\n\n";
$md .= "---\n\n";

$md .= "## Table of Contents\n\n";
foreach ($tables as $table) {
    $md .= "- [$table](#$table)\n";
}
$md .= "\n---\n\n";

$allForeignKeys = [];

foreach ($tables as $table) {
    $md .= "## `$table`\n\n";
    
    // Row count
    $count = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
    $md .= "**Row count:** $count\n\n";
    
    // Column details
    $md .= "| Column | Type | Nullable | Default | Key | Extra |\n";
    $md .= "|--------|------|----------|---------|-----|-------|\n";
    
    $columns = $pdo->query("SHOW FULL COLUMNS FROM `$table`")->fetchAll();
    foreach ($columns as $col) {
        $nullable = ($col['Null'] === 'YES') ? 'YES' : 'NO';
        $default = $col['Default'] ?? 'NULL';
        if ($default === '' || $default === null) $default = 'NULL';
        $key = $col['Key'] ?: '—';
        $extra = $col['Extra'] ?: '—';
        $md .= "| `{$col['Field']}` | `{$col['Type']}` | $nullable | `$default` | `$key` | $extra |\n";
    }
    
    $md .= "\n";
    
    // Foreign keys
    $fkQuery = "
        SELECT 
            COLUMN_NAME,
            REFERENCED_TABLE_NAME,
            REFERENCED_COLUMN_NAME,
            CONSTRAINT_NAME
        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
        WHERE 
            TABLE_SCHEMA = :dbname 
            AND TABLE_NAME = :table 
            AND REFERENCED_TABLE_NAME IS NOT NULL
    ";
    $stmt = $pdo->prepare($fkQuery);
    $stmt->execute([':dbname' => $dbname, ':table' => $table]);
    $foreignKeys = $stmt->fetchAll();
    
    if (!empty($foreignKeys)) {
        $md .= "**Foreign Keys:**\n\n";
        $md .= "| Constraint | Column | References |\n";
        $md .= "|------------|--------|------------|\n";
        foreach ($foreignKeys as $fk) {
            $ref = "`{$fk['REFERENCED_TABLE_NAME']}`.`{$fk['REFERENCED_COLUMN_NAME']}`";
            $md .= "| `{$fk['CONSTRAINT_NAME']}` | `{$fk['COLUMN_NAME']}` | $ref |\n";
            
            $allForeignKeys[] = [
                'from_table' => $table,
                'from_column' => $fk['COLUMN_NAME'],
                'to_table' => $fk['REFERENCED_TABLE_NAME'],
                'to_column' => $fk['REFERENCED_COLUMN_NAME'],
                'constraint' => $fk['CONSTRAINT_NAME'],
            ];
        }
        $md .= "\n";
    }
    
    // Indexes
    $indexes = $pdo->query("SHOW INDEX FROM `$table`")->fetchAll();
    $nonPkIndexes = array_filter($indexes, function($idx) {
        return $idx['Key_name'] !== 'PRIMARY';
    });
    if (!empty($nonPkIndexes)) {
        $seen = [];
        $md .= "**Indexes (non-primary):**\n\n";
        foreach ($nonPkIndexes as $idx) {
            $keyName = $idx['Key_name'];
            if (!isset($seen[$keyName])) {
                $seen[$keyName] = true;
                $unique = $idx['Non_unique'] ? '' : ' (UNIQUE)';
                $md .= "- `{$idx['Key_name']}` on `{$idx['Column_name']}`$unique\n";
            }
        }
        $md .= "\n";
    }
    
    $md .= "---\n\n";
}

// Foreign key relationships section
$md .= "## Relationships\n\n";
$md .= "### Foreign Key Mappings\n\n";
$md .= "| From Table | From Column | → | To Table | To Column |\n";
$md .= "|------------|-------------|---|----------|-----------|\n";

foreach ($allForeignKeys as $fk) {
    $md .= "| `{$fk['from_table']}` | `{$fk['from_column']}` | → | `{$fk['to_table']}` | `{$fk['to_column']}` |\n";
}

$md .= "\n### Relationship Descriptions (Plain Language)\n\n";

// Group FKs by from_table
$groupedFKs = [];
foreach ($allForeignKeys as $fk) {
    $groupedFKs[$fk['from_table']][] = $fk;
}

foreach ($groupedFKs as $fromTable => $fks) {
    foreach ($fks as $fk) {
        // Determine relationship type
        $relType = determineRelationship($pdo, $fromTable, $fk['to_table'], $fk['from_column'], $dbname);
        $md .= "- `{$fromTable}`.`{$fk['from_column']}` → `{$fk['to_table']}`.`{$fk['to_column']}` ($relType)\n";
    }
}

// Also detect Eloquent-style relationships from model files
$md .= "\n### Detected Eloquent Relationships (from Models)\n\n";
$md .= "| App | Model | Relationship | Related Model | Type |\n";
$md .= "|-----|-------|-------------|---------------|------|\n";

$apps = ['dash', 'web'];
foreach ($apps as $app) {
    $modelsDir = "$basePath/$app/app/Models";
    if (!is_dir($modelsDir)) continue;
    $modelFiles = glob("$modelsDir/*.php");
    foreach ($modelFiles as $modelFile) {
        $modelName = basename($modelFile, '.php');
        $content = file_get_contents($modelFile);
        
        // Find relationship methods
        preg_match_all('/function\s+(\w+)\s*\(.*?\)\s*(?::\s*(\\\\?[\w\\\\]+))?\s*\{/', $content, $methodMatches);
        
        // Find belongsTo, hasMany etc calls
        preg_match_all('/\$\s*this\s*->\s*(belongsTo|hasMany|hasOne|belongsToMany|hasManyThrough|morphMany|morphTo|morphOne)\s*\(\s*(\\\\?[\w\\\\]+(?:::\s*class)?)\s*(?:,\s*([^)]+))?\)/', $content, $relMatches);
        
        if (!empty($relMatches[1])) {
            foreach ($relMatches[1] as $i => $relType) {
                $relatedModel = $relMatches[2][$i];
                $relatedModelShort = basename(str_replace('\\', '/', str_replace('::class', '', $relatedModel)));
                $methodName = $methodMatches[1][$i] ?? '?';
                $md .= "| $app | `$modelName` | `$methodName()` | `$relatedModelShort` | `$relType` |\n";
            }
        }
    }
}

file_put_contents($outputFile, $md);
echo "Report saved to: $outputFile\n";

function determineRelationship($pdo, $fromTable, $toTable, $fromColumn, $dbname) {
    try {
        // Check if from_column is unique in from_table (suggests hasOne)
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as cnt, COUNT(DISTINCT `$fromColumn`) as distinct_cnt 
            FROM `$fromTable`
        ");
        $stmt->execute();
        $row = $stmt->fetch();
        $total = $row['cnt'];
        $distinct = $row['distinct_cnt'];
        
        if ($total == 0) return 'relationship unknown (empty table)';
        
        // Check cardinality
        $isUnique = ($total == $distinct);
        
        // Check if from_column is a primary key or unique
        $colInfo = $pdo->query("SHOW COLUMNS FROM `$fromTable` WHERE Field = '$fromColumn'")->fetch();
        $isPk = ($colInfo && $colInfo['Key'] === 'PRI');
        $isUniqueCol = ($colInfo && $colInfo['Key'] === 'UNI');
        
        if ($isPk) return 'one-to-one (FK is PK in source)';
        if ($isUniqueCol) return 'one-to-one (FK is unique in source)';
        if (!$isUnique) return 'many-to-one (many ' . $fromTable . ' per ' . $toTable . ')';
        
        return 'one-to-one (unique FK values in source)';
    } catch (Exception $e) {
        return 'relationship detected';
    }
}
