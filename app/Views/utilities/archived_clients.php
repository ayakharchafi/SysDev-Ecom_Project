<?php
use database\DatabaseConnectionManager;
use controllers\ArchivedClientController;
require __DIR__.'/../../../vendor/autoload.php'; 
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__."/../../../");
$dotenv->load();
require_once __DIR__ . '/../../Controllers/ArchivedClientController.php';
 $ac = new ArchivedClientController();
$clients = $ac->read() ;
?>
<div class="table-container">
    <div class="table-header">
        <h2>Archived Clients</h2>
    </div>
    <table id="dataTable">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Location ID</th>
                <th>Address</th>
                <th>Location</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Premium</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php if (count($clients) === 0): ?>
            <tr>
                <td colspan="9" class="text-center">No archived clients found
                </td>
            </tr>
            <?php else: ?>
            <?php foreach ($clients as $c): ?>
            <tr>
                <td><input type="checkbox" value="<?= $c['id'] ?>"></td>
                <td id="idBox"><?= $c['id'] ?></td>
                <td><?= htmlspecialchars($c['location_id']) ?></td>
                <td><?= htmlspecialchars($c['location_address']) ?></td>
                <td><?= htmlspecialchars("{$c['location_city']}, {$c['location_province']}") ?>
                </td>
                <td><?= $c['first_date_of_coverage'] ?></td>
                <td><?= $c['last_date_of_coverage'] ?></td>
                <td><?= htmlspecialchars("{$c['currency']} {$c['premium_collected']}") ?>
                </td>
                <td>
                    <button class="action-btn edit-btn"
                        data-id="<?= $c['id'] ?>">
                        <i class="fa-solid fa-edit"></i>
                    </button>
                    <button class="action-btn delete-btn"
                        data-id="<?= $c['id'] ?>">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
    <button id="restoreBtn" class="btn btn-primary">
        <i class="fa-solid fa-rotate-right"></i> Restore Selected
    </button>
    <script src="/tern_app/SysDev-Ecom_Project/public/js/archived_clients.js">
    </script>
</div>