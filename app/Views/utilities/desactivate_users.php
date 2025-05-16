<?php
$users = [
  ['id'=>1,'name'=>'Alice','email'=>'alice@example.com'],
  ['id'=>2,'name'=>'Bob','email'=>'bob@example.com'],
];
?>
<div class="table-container">
    <div class="table-header">
        <h2>Deactivated Users</h2>
    </div>
    <table id="dataTable">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAllDeact"></th>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $u): ?>
            <tr>
                <td><input type="checkbox" value="<?= $u['id'] ?>"></td>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['name']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                    <button class="action-btn"><i
                            class="fa-solid fa-user-check"></i></button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="table-footer" style="margin-top:10px;">
        <button id="activateUsersBtn" class="btn btn-primary">
            <i class="fa-solid fa-user-check"></i> Activate Users Selected
        </button>
    </div>
</div>