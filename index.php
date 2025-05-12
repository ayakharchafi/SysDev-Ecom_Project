<?php
require_once __DIR__ . '/vendor/autoload.php';

use controllers\AuthController;
use controllers\DashboardController;
use Dotenv\Dotenv;
use controllers\MkClientController;


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

// switch ($request) {
//     case 'login':
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $authController->processLogin();
//         } else {
//             $authController->showLogin();
//         }
//         break;

//     case 'dashboard':
//         $dashboardController->showDashboard();
//         break;

//     case 'logout':
//         $authController->logout();
//         break;

//     case 'verify-2fa':
//         include "app/Views/authentication/verify_2fa.php"; 
//         break;
        
//     case 'process-verify-2fa':
//         echo "hello";
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $authController->processVerify2FA();
//         }
//         break;

//     default:
//         header("HTTP/1.0 404 Not Found");
//         echo "404 - Page Not Found";
//         break;
// }

// Update the switch statement to include routes for client operations
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
        
    case 'create-client':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('Location: /tern_app/SysDev-Ecom_Project/login');
            exit;
        }
        include "app/Views/clients/create_client.php";
        break;
        
    case 'mk-clients':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('Location: /tern_app/SysDev-Ecom_Project/login');
            exit;
        }
        require_once __DIR__ . '/app/Controllers/MkClientController.php';
        $controller = new controllers\MkClientController();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = $controller->read();
            echo $controller->displayClients($data);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle POST request for creating a client
            $data = [
                'location_id' => $_POST['location_id'] ?? '',
                'first_date_of_coverage' => $_POST['first_date_of_coverage'] ?? '',
                'last_date_of_coverage' => $_POST['last_date_of_coverage'] ?? '',
                'location_address' => $_POST['location_address'] ?? '',
                'location_postal_code' => $_POST['location_postal_code'] ?? '',
                'location_city' => $_POST['location_city'] ?? '',
                'location_province' => $_POST['location_province'] ?? '',
                'number_of_bedrooms' => $_POST['number_of_bedrooms'] ?? '',
                'number_of_days_occupied' => $_POST['number_of_days_occupied'] ?? '',
                'currency' => $_POST['currency'] ?? '',
                'premium_collected' => $_POST['premium_collected'] ?? ''
            ];
            $result = $controller->createClient($data);
            echo json_encode(['success' => $result, 'message' => $result ? 'Client created successfully' : 'Failed to create client']);
        }
        break;

        case 'mkclient/search':
            require_once __DIR__ . '/app/Controllers/MkClientController.php'; // if not already required
            $mkClientController = new MkClientController();
            $searchTerm = $_GET['search'] ?? '';
            $results = $mkClientController->searchClients($searchTerm);
        
            header('Content-Type: application/json');
            echo json_encode($results);
            exit;
        

    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page Not Found";
        break;
    if ($_SERVER['REQUEST_URI'] === '/tern_app/SysDev-Ecom_Project/import') {
            include __DIR__ . '/views/utilities/importview.php';
            exit;
        }
}

?>