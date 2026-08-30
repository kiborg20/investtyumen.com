<?php
/**
 * Converts Bitrix database from utf8/utf8mb3 to utf8mb4.
 *
 * Usage:
 *   php fix_charset.php                  # dry-run
 *   php fix_charset.php --apply          # apply changes
 *   php fix_charset.php --apply --table=b_agent
 *   php fix_charset.php --apply --skip-db
 *
 * Remove this file after migration.
 */

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_NO_ACCELERATOR_RESET', true);

$_SERVER['DOCUMENT_ROOT'] = __DIR__;
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Application;

const TARGET_CHARSET = 'utf8mb4';
const TARGET_COLLATION = 'utf8mb4_unicode_ci';

$apply = in_array('--apply', $argv ?? [], true);
$skipDb = in_array('--skip-db', $argv ?? [], true);
$tableFilter = null;

foreach ($argv ?? [] as $arg) {
    if (str_starts_with($arg, '--table=')) {
        $tableFilter = substr($arg, 8);
    }
}

$connection = Application::getConnection();
$helper = $connection->getSqlHelper();
$dbName = $connection->getDbName();

echo $apply ? "APPLY mode\n" : "DRY-RUN mode (add --apply to execute)\n";
echo "Database: {$dbName}\n";
echo "Target: " . TARGET_CHARSET . ' / ' . TARGET_COLLATION . "\n\n";

$errors = [];
$converted = 0;
$skipped = 0;

if (!$skipDb) {
    $sql = 'ALTER DATABASE `' . $helper->forSql($dbName) . '` CHARACTER SET '
        . TARGET_CHARSET . ' COLLATE ' . TARGET_COLLATION;
    echo $sql . "\n";
    if ($apply) {
        try {
            $connection->queryExecute($sql);
        } catch (Throwable $e) {
            $errors[] = 'DATABASE: ' . $e->getMessage();
        }
    }
    echo "\n";
}

$tablesResult = $connection->query(
    "SELECT TABLE_NAME, TABLE_COLLATION
     FROM information_schema.TABLES
     WHERE TABLE_SCHEMA = '" . $helper->forSql($dbName) . "'
       AND TABLE_TYPE = 'BASE TABLE'
     ORDER BY TABLE_NAME"
);

while ($table = $tablesResult->fetch()) {
    $tableName = $table['TABLE_NAME'];

    if ($tableFilter !== null && $tableName !== $tableFilter) {
        continue;
    }

    $needsConversion = needsConversion($connection, $helper, $dbName, $tableName, $table['TABLE_COLLATION']);

    if (!$needsConversion) {
        $skipped++;
        continue;
    }

    $sql = 'ALTER TABLE `' . $helper->forSql($tableName) . '` CONVERT TO CHARACTER SET '
        . TARGET_CHARSET . ' COLLATE ' . TARGET_COLLATION;
    echo $sql . "\n";

    if ($apply) {
        try {
            $connection->queryExecute($sql);
            $converted++;
        } catch (Throwable $e) {
            $errors[] = $tableName . ': ' . $e->getMessage();
            echo "  ERROR: " . $e->getMessage() . "\n";
        }
    } else {
        $converted++;
    }
}

echo "\n--- Summary ---\n";
echo "To convert: {$converted}\n";
echo "Already ok: {$skipped}\n";

if ($errors) {
    echo "Errors: " . count($errors) . "\n";
    foreach ($errors as $error) {
        echo "  - {$error}\n";
    }
}

function needsConversion($connection, $helper, string $dbName, string $tableName, ?string $tableCollation): bool
{
    if ($tableCollation !== null && !isTargetCollation($tableCollation)) {
        return true;
    }

    $columnsResult = $connection->query(
        "SELECT CHARACTER_SET_NAME, COLLATION_NAME
         FROM information_schema.COLUMNS
         WHERE TABLE_SCHEMA = '" . $helper->forSql($dbName) . "'
           AND TABLE_NAME = '" . $helper->forSql($tableName) . "'
           AND CHARACTER_SET_NAME IS NOT NULL"
    );

    while ($column = $columnsResult->fetch()) {
        if (!isTargetCharset($column['CHARACTER_SET_NAME']) || !isTargetCollation($column['COLLATION_NAME'])) {
            return true;
        }
    }

    return false;
}

function isTargetCharset(?string $charset): bool
{
    return $charset === TARGET_CHARSET;
}

function isTargetCollation(?string $collation): bool
{
    if ($collation === null) {
        return true;
    }

    if ($collation === TARGET_COLLATION) {
        return true;
    }

    // utf8/utf8mb3 collations are not acceptable after migration.
    return str_starts_with($collation, 'utf8mb4_');
}
