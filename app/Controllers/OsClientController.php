<?php
namespace controllers;
require_once __DIR__ . '/../Models/os_occupancy_reports.php';
require_once __DIR__ . '/../Core/Database/databaseconnectionmanager.php';
use models\Os_occupancy_reports;
use database\DatabaseConnectionManager;

class OsClientController {
    private $dbConnection;

    public function __construct() {
        // Initialize the database connection
        $this->dbConnection = (new DatabaseConnectionManager())->getConnection();
    }

    public function read() {
        $query = "SELECT * FROM os_occupancy_reports";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function searchClients($searchTerm) {
        $query = "SELECT * FROM os_occupancy_reports WHERE 
                  guest_name LIKE :searchTerm OR 
                  client_name LIKE :searchTerm OR 
                  unit_address LIKE :searchTerm OR 
                  city LIKE :searchTerm";
        $stmt = $this->dbConnection->prepare($query);
        $searchParam = "%$searchTerm%";
        $stmt->bindParam(':searchTerm', $searchParam);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getClientById($id) {
        $query = "SELECT * FROM os_occupancy_reports WHERE id = :id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function displayClients($data) {
        $html = "";
        
        foreach ($data as $client) {
            $html .= "<tr>";
            $html .= "<td><input type='checkbox'><td>";           
            $html .= "<td>{$client["id"]}</td>";
            $html .= "<td>{$client["guest_name"]}</td>";
            $html .= "<td>{$client["client_name"]}</td>";
            $html .= "<td>{$client["unit_address"]}</td>";
            $html .= "<td>{$client["guest_arrival_date"]}</td>";
            $html .= "<td>{$client["guest_depart_date"]}</td>";
            $html .= "<td>{$client["days_occupied"]}</td>";
            $html .= "<td>\${$client["ternkey_tenant_coverage"]}</td>";
            $html .= "<td>";
            $html .= "<button class='action-btn edit-btn' data-id='{$client["id"]}'><i class='fa-solid fa-edit'></i></button>";
            $html .= "<button class='action-btn delete-btn' data-id='{$client["id"]}'><i class='fa-solid fa-trash'></i></button>";
            $html .= "</td>";
            $html .= "</tr>";
        }
        
        if (empty($data)) {
            $html .= "<tr><td colspan='9' class='text-center'>No clients found</td></tr>";
        }
        
        return $html;
    }
}

// API endpoint to handle client search requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $clients = new OsClientController();
    $searchTerm = $_GET['search'];
    $data = $clients->searchClients($searchTerm);
    echo json_encode($data);
    exit;
}

// API endpoint to get all clients
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['search']) && !isset($_GET['id'])) {
    $clients = new OsClientController();
    $data = $clients->read();
    echo $clients->displayClients($data);
    exit;
}

// API endpoint to get a specific client by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $clients = new OsClientController();
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
