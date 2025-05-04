<?php
use controllers\AuthController;
use controllers\DashboardController;
// ADD THIS AT THE VERY TOP
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET)) {
    if ((isset($_GET['lang']))) {
        
        $lang = $_GET['lang'];

        $localeName = explode('_', $_GET['lang'])[0];

        setlocale(LC_ALL,  $localeName.".UTF8");

        bindtextdomain($lang, "locale");

        textdomain($lang);

        echo gettext("Hello");
        echo '</br>';
    }
}

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
}

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

    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page Not Found";
        break;
}
?>