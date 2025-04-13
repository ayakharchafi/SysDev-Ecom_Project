<?php
// Load the controller using absolute path
require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/DashboardController.php';

session_set_cookie_params([
    'lifetime' => 86400,        // 1 day
    'path' => '/tern_application/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => true,          // Enable in production
    'httponly' => true,
    'samesite' => 'Strict'
]);

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

    case 'logout':
        $authController->logout();
        break;
        
    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page Not Found";
        break;
}
?>