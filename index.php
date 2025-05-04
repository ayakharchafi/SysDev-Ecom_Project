<?php
require_once __DIR__ . '/vendor/autoload.php';

use controllers\AuthController;
use controllers\DashboardController;
use Dotenv\Dotenv;

// ADD THIS AT THE VERY TOP
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_set_cookie_params([
    'lifetime' => 86400,
    'path' => '/tern_app/SysDev-Ecom_Project/',
    'secure' => false, // Set to true in production
    'httponly' => true,
    'samesite' => 'Strict'
]);

// Start session before any output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

require_once __DIR__ . '/locale.php';
require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/DashboardController.php';
require_once __DIR__ . '/app/Models/User.php';


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
        $dashboardController->showDashboard();
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'verify-2fa':
        include "app/Views/authentication/verify_2fa.php"; 
        break;
        
    case 'process-verify-2fa':
        echo "hello";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->processVerify2FA();
        }
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page Not Found";
        break;
}
?>