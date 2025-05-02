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
          $html .=  "<div class='sub-item'>{$client["client_name"]}</div>";
        }
     
        
        echo $html;
    }
}

// API endpoint to retrieve all users from the database (used in main.js)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $clients  = new ClientController;
    $data = $clients->read();
    echo $clients->displayClients($data);
}


?>