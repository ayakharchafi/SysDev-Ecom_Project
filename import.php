<?php
require_once __DIR__ . '/app/Core/Database/databaseconnectionmanager.php';

use database\DatabaseConnectionManager;

// Fetch clients from DB
$stmt = $pdo->query("SELECT id, name, table_name FROM clients");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<form action="handle_import.php" method="post" enctype="multipart/form-data">
  <label for="client">Select Client:</label>
  <select name="client_table" id="client" required>
    <?php foreach ($clients as $client): ?>
      <option value="<?= htmlspecialchars($client['table_name']) ?>">
        <?= htmlspecialchars($client['name']) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <br><br>

  <label for="csv_file">Select CSV file:</label>
  <input type="file" name="csv_file" id="csv_file" accept=".csv" required>

  <br><br>
  <input type="submit" value="Import CSV">
</form>
