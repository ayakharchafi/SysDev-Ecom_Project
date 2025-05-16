
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
        
    case 'clients':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('Location: /tern_app/SysDev-Ecom_Project/login');
            exit;
        }
        require_once __DIR__ . '/app/Controllers/ClientController.php';
        $controller = new controllers\ClientController();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = $controller->read();
            echo $controller->displayClients($data);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle different HTTP methods via POST with _method parameter
            if (isset($_POST['_method'])) {
                if ($_POST['_method'] === 'PUT') {
                    // Update client
                    $data = [
                        'client_id' => $_POST['client_id'] ?? '',
                        'client_name' => $_POST['client_name'] ?? ''
                    ];
                    $result = $controller->updateClient($data);
                    echo json_encode(['success' => $result, 'message' => $result ? 'Client updated successfully' : 'Failed to update client']);
                } elseif ($_POST['_method'] === 'DELETE') {
                    // Delete client
                    $clientId = $_POST['client_id'] ?? '';
                    $result = $controller->deleteClient($clientId);
                    echo json_encode($result);
                }
            } else {
                // Create client
                $data = [
                    'client_id' => $_POST['client_id'] ?? '',
                    'client_name' => $_POST['client_name'] ?? ''
                ];
                $result = $controller->createClient($data);
                echo json_encode(['success' => $result, 'message' => $result ? 'Client created successfully' : 'Failed to create client']);
            }
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
        
    case 'edit-client':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('Location: /tern_app/SysDev-Ecom_Project/login');
            exit;
        }
        include "app/Views/clients/edit_client.php";
        break;
        
    case 'create-row':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('Location: /tern_app/SysDev-Ecom_Project/login');
            exit;
        }
        include "app/Views/clients/create_row.php";
        break;
    case 'archive-clients':
    header('Content-Type: application/json');
    $ids =  explode(",",$_REQUEST['ids']);
    require_once __DIR__ . '/app/Controllers/ArchivedClientController.php';
    $ctrl = new controllers\ArchivedClientController();
    $ok = $ctrl->archiveClients($ids);
    echo json_encode([
      'success' => $ok,
      'message' => $ok
        ? "Archived {$ok} client(s)."
        : "Failed to archive clients."
    ]);
    exit;

case 'restore-clients':
    header('Content-Type: application/json');
    $ids =  explode(",",$_REQUEST['ids']);
    require_once __DIR__ . '/app/Controllers/ArchivedClientController.php';
    $ctrl = new controllers\ArchivedClientController();
    $ok = $ctrl->restoreClients($ids);
    echo json_encode([
      'success' => $ok,
      'message' => $ok
        ? "Restored {$ok} client(s)."
        : "Failed to restore clients."
    ]);
    exit;

// index.php (the switch on $_GET['url'])
case 'deactivated-users':
    // ensure logged in, if you like
    if (!isset($_SESSION['user'])) {
      header('Location:/tern_app/SysDev-Ecom_Project/login');
      exit;
    }
    // just echo the fragment
    include __DIR__ . '/app/Views/utilities/desactivate_users.php';
    exit;
        
    case 'mk-clients':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('Location: /tern_app/SysDev-Ecom_Project/login');
            exit;
        }
        require_once __DIR__ . '/app/Controllers/MkClientController.php';
        $controller = new controllers\MkClientController();
       if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // look for archived flag in query string
    $archived = isset($_GET['archived']) && $_GET['archived']==='1';
    // pass it into read()
     $data = $controller->read($archived);
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
            echo json_encode(['success' => $result, 'message' => $result ? 'Row created successfully' : 'Failed to create row']);
        }
        break;

    case 'os-clients':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('Location: /tern_app/SysDev-Ecom_Project/login');
            exit;
        }
        require_once __DIR__ . '/app/Controllers/OsClientController.php';
        $controller = new controllers\OsClientController();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = $controller->read();
            echo $controller->displayClients($data);
        }
        break;

    case 'bg-clients':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('Location: /tern_app/SysDev-Ecom_Project/login');
            exit;
        }
        require_once __DIR__ . '/app/Controllers/BgClientController.php';
        $controller = new controllers\BgClientController();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = $controller->read();
            echo $controller->displayClients($data);
        }
        break;

    case 'th-clients':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('Location: /tern_app/SysDev-Ecom_Project/login');
            exit;
        }
        require_once __DIR__ . '/app/Controllers/ThClientController.php';
        $controller = new controllers\ThClientController();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = $controller->read();
            echo $controller->displayClients($data);
        }
        break;

    case 'api_get_client':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        require_once __DIR__ . '/app/Controllers/ClientController.php';
        $controller = new controllers\ClientController();
        $clientId = $_GET['id'] ?? '';
        $client = $controller->getClientById($clientId);
        echo json_encode($client);
        break;

    case 'api_create_client':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        require_once __DIR__ . '/app/Controllers/ClientController.php';
        $controller = new controllers\ClientController();
        
        // Get JSON data
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
            exit;
        }
        
        $result = $controller->createClient($data);
        echo json_encode(['success' => $result, 'message' => $result ? 'Client created successfully' : 'Failed to create client']);
        break;

    case 'api_update_client':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        require_once __DIR__ . '/app/Controllers/ClientController.php';
        $controller = new controllers\ClientController();
        
        // Get JSON data
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
            exit;
        }
        
        $result = $controller->updateClient($data);
        echo json_encode(['success' => $result, 'message' => $result ? 'Client updated successfully' : 'Failed to update client']);
        break;

    case 'api_delete_client':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        require_once __DIR__ . '/app/Controllers/ClientController.php';
        $controller = new controllers\ClientController();
        $clientId = $_GET['id'] ?? '';
        $result = $controller->deleteClient($clientId);
        echo json_encode($result);
        break;

    case 'api_get_clients':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        require_once __DIR__ . '/app/Controllers/ClientController.php';
        $controller = new controllers\ClientController();
        $data = $controller->read();
        echo json_encode($data);
        break;

    case 'api_get_os_reports':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        require_once __DIR__ . '/app/Controllers/OsClientController.php';
        $controller = new controllers\OsClientController();
        $data = $controller->read();
        echo json_encode($data);
        break;

    case 'api_get_bg_gl_reports':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        require_once __DIR__ . '/app/Controllers/BgClientController.php';
        $controller = new controllers\BgClientController();
        $data = $controller->read();
        echo json_encode($data);
        break;

    case 'api_get_th_gl_reports':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        require_once __DIR__ . '/app/Controllers/ThClientController.php';
        $controller = new controllers\ThClientController();
        $data = $controller->read();
        echo json_encode($data);
        break;

    case 'api_get_mk_reports':
        // Make sure the user is logged in
        if (!isset($_SESSION['user'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        require_once __DIR__ . '/app/Controllers/MkClientController.php';
        $controller = new controllers\MkClientController();
        $data = $controller->read();
        echo json_encode($data);
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page Not Found";
        break;
}
