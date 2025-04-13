<?php
// Load the controller using absolute path
require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/DashboardController.php';

$authController = new AuthController();
$dashboardController = new DashboardController();

$request = $_GET['url'] ?? 'login';

switch ($request) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->processLogin();
        } else {
            $authController->showLogin();
        }
        break;

    case 'dashboard':
        // echo "Welcome to Dashboard!";
        $dashboardController->showDashboard();
        break;
        
    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page Not Found";
        break;
}
?>