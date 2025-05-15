<?php
require_once __DIR__ . '/app/Core/Database/databaseconnectionmanager.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $table = $_POST['client_table'];
    $file = $_FILES['csv_file']['tmp_name'];

    if (!file_exists($file)) {
        die("File not found.");
    }

    $handle = fopen($file, 'r');
    if (!$handle) {
        die("Unable to open file.");
    }

    $columns = fgetcsv($handle); // First line = headers

    // Validate: make sure table and columns match
    $placeholders = implode(',', array_fill(0, count($columns), '?'));
    $columns_sql = implode(',', array_map(fn($col) => "`$col`", $columns));

    $insert_sql = "INSERT INTO `$table` ($columns_sql) VALUES ($placeholders)";
    $stmt = $pdo->prepare($insert_sql);

    while (($data = fgetcsv($handle)) !== false) {
        $stmt->execute($data);
    }

    fclose($handle);
    echo "CSV data imported successfully into $table.";
} else {
    echo "Invalid request.";
}
