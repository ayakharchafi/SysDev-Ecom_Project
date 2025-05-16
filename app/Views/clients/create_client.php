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
            <label  style = "color: white;" for="location_id">Location ID</label>
            <input type="text" id="location_id" name="location_id" required>
        </div>
        <div class="form-group">
            <label  style = "color: white;" for="location_address">Building Address</label>
            <input type="text" id="location_address" name="location_address" required>
        </div>
        
        <div class="form-group">
            <label  style = "color: white;" for="location_postal_code">Postal Code</label>
            <input type="text" id="location_postal_code" name="location_postal_code" required>
        </div>
        
        <div class="form-row">
            <div class="form-group half">
                <label  style = "color: white;" for="location_city">City</label>
                <input type="text" id="location_city" name="location_city" required>
            </div>
            
            <div class="form-group half">
                <label  style = "color: white;" for="location_province">Province</label>
                <input type="text" id="location_province" name="location_province" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group half">
                <label  style = "color: white;" for="first_date_of_coverage">Stay Start Date</label>
                <input type="date" id="first_date_of_coverage" name="first_date_of_coverage" required>
            </div>
            
            <div class="form-group half">
                <label  style = "color: white;" for="last_date_of_coverage">Stay End Date</label>
                <input type="date" id="last_date_of_coverage" name="last_date_of_coverage" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group half">
                <label  style = "color: white;" for="number_of_bedrooms">Number of Bedrooms</label>
                <input type="number" id="number_of_bedrooms" name="number_of_bedrooms" min="1" required>
            </div>
            
            <div class="form-group half">
                <label  style = "color: white;" for="number_of_days_occupied">Days Occupied</label>
                <input type="number" id="number_of_days_occupied" name="number_of_days_occupied" min="1" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group half">
                <label  style = "color: white;" for="currency">Currency</label>
                <select id="currency" name="currency" required>
                    <option value="CAD">CAD</option>
                    <option value="USD">USD</option>
                </select>
            </div>
            
            <div class="form-group half">
                <label  style = "color: white;" for="premium_collected">Premium Collected</label>
                <input type="number" id="premium_collected" name="premium_collected" step="0.01" min="0" required>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="button" id="cancelBtn" class="btn btn-secondary">Cancel</button>
            <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
    </form>
</div>
