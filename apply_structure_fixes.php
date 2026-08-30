<?php
/**
 * Applies ALTER TABLE fixes from Bitrix site checker log.
 *
 * Usage:
 *   php apply_structure_fixes.php              # dry-run
 *   php apply_structure_fixes.php --apply      # execute
 *   php apply_structure_fixes.php --file=/path/to/fix.sql --apply
 *
 * Remove this file after migration.
 */

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_NO_ACCELERATOR_RESET', true);

$_SERVER['DOCUMENT_ROOT'] = __DIR__;
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Application;

$apply = in_array('--apply', $argv ?? [], true);
$customFile = null;

foreach ($argv ?? [] as $arg) {
    if (str_starts_with($arg, '--file=')) {
        $customFile = substr($arg, 7);
    }
}

$connection = Application::getConnection();
$queries = [];

if ($customFile !== null) {
    if (!is_readable($customFile)) {
        fwrite(STDERR, "File not readable: {$customFile}\n");
        exit(1);
    }
    $queries = extractAlterQueries(file_get_contents($customFile));
} else {
    $logFiles = glob($_SERVER['DOCUMENT_ROOT'] . '/bitrix/site_checker_*.log') ?: [];
    rsort($logFiles);

    foreach ($logFiles as $logFile) {
        $queries = extractAlterQueries(file_get_contents($logFile));
        if ($queries) {
            echo "Using log: {$logFile}\n";
            break;
        }
    }
}

if (!$queries) {
    fwrite(STDERR, "No ALTER TABLE queries found.\n");
    fwrite(STDERR, "Run site checker first, or pass --file=fix_structure.sql\n");
    exit(1);
}

echo ($apply ? "APPLY mode\n" : "DRY-RUN mode (add --apply to execute)\n");
echo 'Queries: ' . count($queries) . "\n\n";

$ok = 0;
$failed = 0;

foreach ($queries as $sql) {
    echo $sql . "\n";

    if (!$apply) {
        continue;
    }

    try {
        $connection->queryExecute($sql);
        $ok++;
    } catch (Throwable $e) {
        $failed++;
        echo "  ERROR: " . $e->getMessage() . "\n";
    }
}

echo "\n--- Summary ---\n";
if ($apply) {
    echo "Applied: {$ok}\n";
    echo "Failed: {$failed}\n";
} else {
    echo "Run with --apply to execute " . count($queries) . " queries.\n";
}

function extractAlterQueries(string $content): array
{
    preg_match_all('/^ALTER TABLE .+;$/m', $content, $matches);

    $queries = [];
    foreach ($matches[0] as $sql) {
        $sql = trim($sql);
        if ($sql !== '') {
            $queries[$sql] = $sql;
        }
    }

    return array_values($queries);
}
