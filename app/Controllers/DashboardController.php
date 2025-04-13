<?php
class DashboardController {
    public function showDashboard()
    {
        require_once __DIR__ . '/../Helpers/AuthHelper.php';
        requireLogin(); // Uses AuthHelper's check
        
        require_once __DIR__ . '/../Views/main/main.php';
    }
}