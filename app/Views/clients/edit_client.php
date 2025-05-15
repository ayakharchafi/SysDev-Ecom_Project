<?php
// Check if user is logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: /tern_app/SysDev-Ecom_Project/login');
    exit;
}
?>

<div class="edit-client-container">
    <h2>Edit Client</h2>
    <form id="editClientForm" class="edit-client-form">
        <input type="hidden" id="edit_client_id" name="client_id">
        
        <div class="form-group">
            <label for="edit_client_name">Client Name</label>
            <input type="text" id="edit_client_name" name="client_name" required maxlength="50">
            <small>Maximum 50 characters</small>
        </div>
        
        <div class="form-actions">
            <button type="button" id="cancelEditBtn" class="btn btn-secondary">Cancel</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
