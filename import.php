<?php
require_once __DIR__ . '/app/Core/Database/databaseconnectionmanager.php';

use database\DatabaseConnectionManager;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client = $_POST['client'];

    if (!isset($_FILES['csv']) || $_FILES['csv']['error'] !== 0) {
        echo "File upload failed.";
        exit;
    }

    $file = $_FILES['csv']['tmp_name'];
    $filename = $_FILES['csv']['name'];

    if (pathinfo($filename, PATHINFO_EXTENSION) !== 'csv') {
        echo "Only CSV files are allowed.";
        exit;
    }

    // Use DatabaseConnectionManager to get PDO
    $dbManager = new DatabaseConnectionManager();
    $pdo = $dbManager->getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $handle = fopen($file, "r");
    if (!$handle) {
        echo "Unable to open file.";
        exit;
    }

    $header = fgetcsv($handle, 1000, ",");
    $columns = array_map(function ($col) {
        return "`" . preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower(trim($col))) . "` VARCHAR(255)";
    }, $header);

    $tableName = "client_" . strtolower($client) . "_" . time();

    // Create table
    $createTableSQL = "CREATE TABLE `$tableName` (" . implode(", ", $columns) . ")";
    $pdo->exec($createTableSQL);

    // Insert rows
    $insertSQL = "INSERT INTO `$tableName` VALUES (" . rtrim(str_repeat("?,", count($header)), ",") . ")";
    $stmt = $pdo->prepare($insertSQL);

    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        $stmt->execute($data);
    }

    fclose($handle);
    echo "CSV data imported to table: $tableName";
}
