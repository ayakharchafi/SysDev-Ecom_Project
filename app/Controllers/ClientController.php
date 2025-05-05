<?php
namespace controllers;
require_once __DIR__ . '/../Models/Client.php';
require_once __DIR__ . '/../Core/Database/databaseconnectionmanager.php';
use models\Client;
use database\DatabaseConnectionManager;

class ClientController{
    private $dbConnection;

    public function __construct() {
        // Initialize the database connection
        $this->dbConnection = (new DatabaseConnectionManager())->getConnection();
    }

    public function read() {
        $query = "SELECT * FROM client";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function displayClients($data){
        $html = "";
        
        foreach ($data as $client) {
          $html .=  "<div class='sub-item' data-client-id='{$client["client_id"]}'>{$client["client_name"]}</div>";
        }
     
        echo $html;
    }

    public function searchClients($searchTerm) {
        $query = "SELECT * FROM client WHERE client_name LIKE :searchTerm";
        $stmt = $this->dbConnection->prepare($query);
        $searchParam = "%$searchTerm%";
        $stmt->bindParam(':searchTerm', $searchParam);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getClientById($clientId) {
        $query = "SELECT * FROM client WHERE client_id = :clientId";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':clientId', $clientId);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}

// API endpoint to retrieve all clients from the database
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $clients = new ClientController;
    
    // Check if it's a search request
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $data = $clients->searchClients($searchTerm);
    } else {
        $data = $clients->read();
    }
    
    echo $clients->displayClients($data);
}

// API endpoint to get a specific client by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['client_id'])) {
    $clients = new ClientController;
    $clientId = $_GET['client_id'];
    $client = $clients->getClientById($clientId);
    
    if ($client) {
        echo json_encode($client);
    } else {
        echo json_encode(['error' => 'Client not found']);
    }
}
?>
