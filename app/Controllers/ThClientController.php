<?php
namespace controllers;
require_once __DIR__ . '/../Models/th_gl_reports.php';
require_once __DIR__ . '/../Core/Database/databaseconnectionmanager.php';
use models\Th_gl_reports;
use database\DatabaseConnectionManager;
class ThClientController {
    private $dbConnection;
    public function __construct() {
        // Initialize the database connection
        $this->dbConnection = (new DatabaseConnectionManager())->getConnection();
    }
    public function read() {
        $query = "SELECT * FROM th_gl_reports";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function searchClients($searchTerm) {
        $query = "SELECT * FROM th_gl_reports WHERE 
                  contract_file_name LIKE :searchTerm OR 
                  property_name LIKE :searchTerm OR 
                  unit_address LIKE :searchTerm OR 
                  city LIKE :searchTerm";
        $stmt = $this->dbConnection->prepare($query);
        $searchParam = "%$searchTerm%";
        $stmt->bindParam(':searchTerm', $searchParam);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getClientById($contractFileName) {
        $query = "SELECT * FROM th_gl_reports WHERE contract_file_name = :contract_file_name";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':contract_file_name', $contractFileName);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function displayClients($data) {
        $html = "";
        foreach ($data as $client) {
            $html .= "<tr>";
            $html .= "<td><input type='checkbox'><td>";           
            $html .= "<td>{$client["contract_file_name"]}</td>";
            $html .= "<td>{$client["property_name"]}</td>";
            $html .= "<td>{$client["unit_address"]}</td>";
            $html .= "<td>{$client["city"]}, {$client["state"]}</td>";
            $html .= "<td>{$client["contract_start_date"]}</td>";
            $html .= "<td>{$client["contract_end_date"]}</td>";
            $html .= "<td>\${$client["total"]}</td>";
            $html .= "<td>";
            $html .= "<button class='action-btn edit-btn' data-id='{$client["contract_file_name"]}'><i class='fa-solid fa-edit'></i></button>";
            $html .= "<button class='action-btn delete-btn' data-id='{$client["contract_file_name"]}'><i class='fa-solid fa-trash'></i></button>";
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
    $clients = new ThClientController();
    $searchTerm = $_GET['search'];
    $data = $clients->searchClients($searchTerm);
    echo json_encode($data);
    exit;
}
// API endpoint to get all clients
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['search']) && !isset($_GET['id'])) {
    $clients = new ThClientController();
    $data = $clients->read();
    echo $clients->displayClients($data);
    exit;
}
// API endpoint to get a specific client by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $clients = new ThClientController();
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