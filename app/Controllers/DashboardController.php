<?php
class DashboardController {
    public function showDashboard()
    {
       // Start session first
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check if user is logged in
    if (empty($_SESSION['user'])) {
        error_log("Dashboard access denied - no session");
        header('Location: /tern_application/login');
        exit;
    }

    require_once __DIR__ . '/../Views/main/main.php';
    }
}