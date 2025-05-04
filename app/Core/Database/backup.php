<?php
// In order for this to work once a week, you need to set a task in task scheduler
// The task that I scheduled on my pc is included in SysDev-Ecom_Project
require_once __DIR__ . '/../../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$backupDir = __DIR__ . "/backups";
// If the directory doesn't exist, create it
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}

$logFile = __DIR__ . '/../../backup.log';
$backupFile = $backupDir . "/db_backup_" . date("Y-m-d") . ".sql";

$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$server = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_DATABASE'];

$command = "mysqldump -h $server -u $username -p'$password' $db_name > $backupFile";

// Execute the command and capture the output
$output = null;
$returnVar = null;
exec($command, $output, $returnVar);

$logMessage = "[" . date("Y-m-d H:i:s") . "] ";
// Output this to a log
if ($returnVar === 0) {
    // echo "Backup successful: $backupFile\n";
    $logMessage = "Backup successful: $backupFile\n";
} else {
    // echo "Backup failed. Error code: $returnVar\n";
    $logMessage = "Backup failed. Error code: $returnVar\n";
}
file_put_contents(__DIR__ . '/backup_log.txt', $logMessage, FILE_APPEND);
?>