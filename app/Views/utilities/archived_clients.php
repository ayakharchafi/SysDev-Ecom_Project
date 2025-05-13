<?php
// app/Views/utilities/archived_clients.php
// — a fragment only, to be injected into the dashboard

// For now we’re using a static array; later you can swap this for
// a real controller call (e.g. (new MkClientController())->readArchived()).
$clients = [
    // [
    //   'id'                      => 1,
    //   'location_id'             => 'MK001',
    //   'location_address'        => '123 Maple St',
    //   'location_city'           => 'Springfield',
    //   'location_province'       => 'IL',
    //   'first_date_of_coverage'  => '2025-04-01',
    //   'last_date_of_coverage'   => '2025-04-10',
    //   'currency'                => 'USD',
    //   'premium_collected'       => '150.00',
    // ],
    // [
    //   'id'                      => 2,
    //   'location_id'             => 'MK002',
    //   'location_address'        => '456 Oak Ave',
    //   'location_city'           => 'Shelbyville',
    //   'location_province'       => 'IL',
    //   'first_date_of_coverage'  => '2025-04-03',
    //   'last_date_of_coverage'   => '2025-04-08',
    //   'currency'                => 'USD',
    //   'premium_collected'       => '200.00',
    // ],
];
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
        <tr><td colspan="9" class="text-center">No archived clients found</td></tr>
      <?php else: ?>
        <?php foreach ($clients as $c): ?>
          <tr>
            <td><input type="checkbox" value="<?= $c['id'] ?>"></td>
            <td><?= $c['id'] ?></td>
            <td><?= htmlspecialchars($c['location_id']) ?></td>
            <td><?= htmlspecialchars($c['location_address']) ?></td>
            <td><?= htmlspecialchars("{$c['location_city']}, {$c['location_province']}") ?></td>
            <td><?= $c['first_date_of_coverage'] ?></td>
            <td><?= $c['last_date_of_coverage'] ?></td>
            <td><?= htmlspecialchars("{$c['currency']} {$c['premium_collected']}") ?></td>
            <td>
              <button class="action-btn edit-btn" data-id="<?= $c['id'] ?>">
                <i class="fa-solid fa-edit"></i>
              </button>
              <button class="action-btn delete-btn" data-id="<?= $c['id'] ?>">
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
</div>
