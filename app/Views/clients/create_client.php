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

<div class="create-client-container">
    <h2 style= "color: white;">Create Client</h2>
    <form id="createClientForm" class="create-client-form">
        <div class="form-group">
            <label for="client_id">Client ID</label>
            <input type="text" id="client_id" name="client_id" required maxlength="5">
            <small>Maximum 5 characters</small>
        </div>
        
        <div class="form-group">
            <label for="client_name">Client Name</label>
            <input type="text" id="client_name" name="client_name" required maxlength="50">
            <small>Maximum 50 characters</small>
        </div>
        
        <div class="form-actions">
            <button type="button" id="cancelBtn" class="btn btn-secondary">Cancel</button>
            <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
    </form>
</div>
