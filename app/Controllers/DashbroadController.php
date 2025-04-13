<?php
class DashboardController {
    public function showDashboard()
    {
        session_start();
        if (empty($_SESSION['user'])) {
            header('Location: /tern_application/login');
            exit;
        }
        
        require_once __DIR__ . '/../Views/main/main.html';
    }
}