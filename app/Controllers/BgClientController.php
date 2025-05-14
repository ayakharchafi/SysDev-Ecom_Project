<?php
namespace controllers;
require_once __DIR__ . '/../Models/bg_ternkey_report_schedule.php';
require_once __DIR__ . '/../Core/Database/databaseconnectionmanager.php';
use models\Bg_ternkey_report_schedule;
use database\DatabaseConnectionManager;

class BgClientController {
    private $dbConnection;

    public function __construct() {
        // Initialize the database connection
        $this->dbConnection = (new DatabaseConnectionManager())->getConnection();
    }

    public function read() {
        $query = "SELECT * FROM bg_ternkey_report_schedule";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function searchClients($searchTerm) {
        $query = "SELECT * FROM bg_ternkey_report_schedule WHERE 
                  booking_version_code LIKE :searchTerm OR 
                  property_code LIKE :searchTerm OR 
                  full_address LIKE :searchTerm OR 
                  city LIKE :searchTerm";
        $stmt = $this->dbConnection->prepare($query);
        $searchParam = "%$searchTerm%";
        $stmt->bindParam(':searchTerm', $searchParam);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getClientById($bookingVersionCode) {
        $query = "SELECT * FROM bg_ternkey_report_schedule WHERE booking_version_code = :booking_version_code";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':booking_version_code', $bookingVersionCode);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function displayClients($data) {
        $html = "";
        
        foreach ($data as $client) {
            $html .= "<tr>";
            $html .= "<td><input type='checkbox'><td>";
            $html .= "<td>{$client["booking_version_code"]}</td>";
            $html .= "<td>{$client["property_code"]}</td>";
            $html .= "<td>{$client["full_address"]}</td>";
            $html .= "<td>{$client["city"]}</td>";
            $html .= "<td>{$client["insurance_start_date"]}</td>";
            $html .= "<td>{$client["insurance_end_date"]}</td>";
            $html .= "<td>\${$client["premium"]}</td>";
            $html .= "<td>";
            $html .= "<button class='action-btn edit-btn' data-id='{$client["booking_version_code"]}'><i class='fa-solid fa-edit'></i></button>";
            $html .= "<button class='action-btn delete-btn' data-id='{$client["booking_version_code"]}'><i class='fa-solid fa-trash'></i></button>";
            $html .= "</td>";
            $html .= "</tr>";
        }
        
        if (empty($data)) {
            $html .= "<tr><td colspan='8' class='text-center'>No clients found</td></tr>";
        }
        
        return $html;
    }
}

// API endpoint to handle client search requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $clients = new BgClientController();
    $searchTerm = $_GET['search'];
    $data = $clients->searchClients($searchTerm);
    echo json_encode($data);
    exit;
}

// API endpoint to get all clients
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['search']) && !isset($_GET['id'])) {
    $clients = new BgClientController();
    $data = $clients->read();
    echo $clients->displayClients($data);
    exit;
}

// API endpoint to get a specific client by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $clients = new BgClientController();
    $clientId = $_GET['id'];
    $client = $clients->getClientById($clientId);
    
    if ($client) {
        echo json_encode($client);
    } else {
        echo json_encode(['error' => 'Client not found']);
    }
    exit;
}
?>
