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
            $html .= "<tr>";
            $html .= "<td>{$client["client_id"]}</td>";
            $html .= "<td>{$client["client_name"]}</td>";
            $html .= "<td>";
            $html .= "<button class='action-btn edit-client-btn' data-id='{$client["client_id"]}' data-name='{$client["client_name"]}'><i class='fa-solid fa-edit'></i></button>";
            $html .= "<button class='action-btn delete-client-btn' data-id='{$client["client_id"]}' data-name='{$client["client_name"]}'><i class='fa-solid fa-trash'></i></button>";
            $html .= "</td>";
            $html .= "</tr>";
        }
        
        if (empty($data)) {
            $html .= "<tr><td colspan='3' class='text-center'>No clients found</td></tr>";
        }
        
        return $html;
    }

    public function searchClients($searchTerm) {
        $query = "SELECT * FROM client WHERE client_name LIKE :searchTerm OR client_id LIKE :searchTerm";
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

    public function createClient($data) {
        $query = "INSERT INTO client (client_id, client_name) VALUES (:client_id, :client_name)";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':client_id', $data['client_id']);
        $stmt->bindParam(':client_name', $data['client_name']);
        return $stmt->execute();
    }

    public function updateClient($data) {
        $query = "UPDATE client SET client_name = :client_name WHERE client_id = :client_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':client_id', $data['client_id']);
        $stmt->bindParam(':client_name', $data['client_name']);
        return $stmt->execute();
    }

    public function deleteClient($clientId) {
        // First check if there are any related records in external_users
        $checkQuery = "SELECT COUNT(*) FROM external_users WHERE client_id = :client_id";
        $checkStmt = $this->dbConnection->prepare($checkQuery);
        $checkStmt->bindParam(':client_id', $clientId);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();
        
        if ($count > 0) {
            return [
                'success' => false,
                'message' => 'Cannot delete client because it has related external users'
            ];
        }
        
        // Also check policy_data
        $checkQuery = "SELECT COUNT(*) FROM policy_data WHERE client_id = :client_id";
        $checkStmt = $this->dbConnection->prepare($checkQuery);
        $checkStmt->bindParam(':client_id', $clientId);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();
        
        if ($count > 0) {
            return [
                'success' => false,
                'message' => 'Cannot delete client because it has related policy data'
            ];
        }
        
        // If no related records, proceed with deletion
        $query = "DELETE FROM client WHERE client_id = :client_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':client_id', $clientId);
        $result = $stmt->execute();
        
        return [
            'success' => $result,
            'message' => $result ? 'Client deleted successfully' : 'Failed to delete client'
        ];
    }
}

// API endpoint to handle client operations
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['search']) && !isset($_GET['id'])) {
    $clients = new ClientController();
    $data = $clients->read();
    echo $clients->displayClients($data);
    exit;
}

// API endpoint to handle client search requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $clients = new ClientController();
    $searchTerm = $_GET['search'];
    $data = $clients->searchClients($searchTerm);
    echo json_encode($data);
    exit;
}

// API endpoint to get a specific client by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $clients = new ClientController();
    $clientId = $_GET['id'];
    $client = $clients->getClientById($clientId);
    
    if ($client) {
        echo json_encode($client);
    } else {
        echo json_encode(['error' => 'Client not found']);
    }
    exit;
}

// API endpoint to create a new client
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['_method'])) {
    $clients = new ClientController();
    
    // Get the data from the POST request
    $data = [
        'client_id' => $_POST['client_id'] ?? '',
        'client_name' => $_POST['client_name'] ?? ''
    ];
    
    // Validate required fields
    if (empty($data['client_id']) || empty($data['client_name'])) {
        echo json_encode([
            'success' => false, 
            'message' => 'Client ID and Client Name are required'
        ]);
        exit;
    }
    
    $result = $clients->createClient($data);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Client created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create client']);
    }
    exit;
}

// API endpoint to update a client
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PUT') {
    $clients = new ClientController();
    
    // Get the data from the POST request
    $data = [
        'client_id' => $_POST['client_id'] ?? '',
        'client_name' => $_POST['client_name'] ?? ''
    ];
    
    // Validate required fields
    if (empty($data['client_id']) || empty($data['client_name'])) {
        echo json_encode([
            'success' => false, 
            'message' => 'Client ID and Client Name are required'
        ]);
        exit;
    }
    
    $result = $clients->updateClient($data);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Client updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update client']);
    }
    exit;
}

// API endpoint to delete a client
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
    $clients = new ClientController();
    
    // Get the client ID from the POST request
    $clientId = $_POST['client_id'] ?? '';
    
    // Validate required fields
    if (empty($clientId)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Client ID is required'
        ]);
        exit;
    }
    
    $result = $clients->deleteClient($clientId);
    echo json_encode($result);
    exit;
}
?>
