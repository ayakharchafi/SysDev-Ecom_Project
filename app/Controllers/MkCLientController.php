<?php
namespace controllers;
require_once __DIR__ . '/../Models/mk_occupancy_reports.php';
require_once __DIR__ . '/../Core/Database/databaseconnectionmanager.php';
use models\Mk_occupancy_reports;
use database\DatabaseConnectionManager;

class MkClientController {
    private $dbConnection;

    public function __construct() {
        // Initialize the database connection
        $this->dbConnection = (new DatabaseConnectionManager())->getConnection();
    }

    public function read() {
        $query = "SELECT * FROM mk_occupancy_reports";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function searchClients($searchTerm) {
        $query = "SELECT id, location_id, location_address, location_city 
                  FROM mk_occupancy_reports 
                  WHERE location_id LIKE :searchTerm 
                  OR location_address LIKE :searchTerm 
                  OR location_city LIKE :searchTerm 
                  OR location_province LIKE :searchTerm";
    
        $stmt = $this->dbConnection->prepare($query);
        $searchParam = "%$searchTerm%";
        $stmt->bindParam(':searchTerm', $searchParam);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    

    public function getClientById($id) {
        $query = "SELECT * FROM mk_occupancy_reports WHERE mk_occupancy_reports_id = :id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // model 
    public function createClient($data) {
        $query = "INSERT INTO mk_occupancy_reports (
            location_id, first_date_of_coverage, last_date_of_coverage, 
            location_address, location_postal_code, location_city, 
            location_province, number_of_bedrooms, number_of_days_occupied, 
            currency, premium_collected
        ) VALUES (
            :location_id, :first_date_of_coverage, :last_date_of_coverage, 
            :location_address, :location_postal_code, :location_city, 
            :location_province, :number_of_bedrooms, :number_of_days_occupied, 
            :currency, :premium_collected
        )";
        
        $stmt = $this->dbConnection->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':location_id', $data['location_id']);
        $stmt->bindParam(':first_date_of_coverage', $data['first_date_of_coverage']);
        $stmt->bindParam(':last_date_of_coverage', $data['last_date_of_coverage']);
        $stmt->bindParam(':location_address', $data['location_address']);
        $stmt->bindParam(':location_postal_code', $data['location_postal_code']);
        $stmt->bindParam(':location_city', $data['location_city']);
        $stmt->bindParam(':location_province', $data['location_province']);
        $stmt->bindParam(':number_of_bedrooms', $data['number_of_bedrooms']);
        $stmt->bindParam(':number_of_days_occupied', $data['number_of_days_occupied']);
        $stmt->bindParam(':currency', $data['currency']);
        $stmt->bindParam(':premium_collected', $data['premium_collected']);
        
        return $stmt->execute();
    }


    // view
    public function displayClients($data) {
        $html = "";
        
        foreach ($data as $client) {
            $html .= "<tr>";
            $html .= "<td>{$client["id"]}</td>";
            $html .= "<td>{$client["location_id"]}</td>";
            $html .= "<td>{$client["location_address"]}</td>";
            $html .= "<td>{$client["location_city"]}, {$client["location_province"]}</td>";
            $html .= "<td>{$client["first_date_of_coverage"]}</td>";
            $html .= "<td>{$client["last_date_of_coverage"]}</td>";
            $html .= "<td>{$client["currency"]} {$client["premium_collected"]}</td>";
            $html .= "<td>";
            $html .= "<button class='action-btn edit-btn' data-id='{$client["id"]}'><i class='fa-solid fa-edit'></i></button>";
            $html .= "<button class='action-btn delete-btn' data-id='{$client["id"]}'><i class='fa-solid fa-trash'></i></button>";
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
    $clients = new MkClientController();
    $searchTerm = $_GET['search'];
    $data = $clients->searchClients($searchTerm);
    echo json_encode($data);
    exit;
}

// API endpoint to get all clients
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['search']) && !isset($_GET['id'])) {
    $clients = new MkClientController();
    $data = $clients->read();
    echo $clients->displayClients($data);
    exit;
}

// API endpoint to get a specific client by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $clients = new MkClientController();
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clients = new MkClientController();
    
    // Get the data from the POST request
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
    
    // Validate required fields
    $requiredFields = ['location_id', 'first_date_of_coverage', 'last_date_of_coverage', 
                      'location_address', 'location_city', 'location_province'];
    
    $missingFields = [];
    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            $missingFields[] = $field;
        }
    }
    
    if (!empty($missingFields)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Missing required fields: ' . implode(', ', $missingFields)
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
?>
