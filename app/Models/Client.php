<?php
namespace models;


require __DIR__.'/../../vendor/autoload.php'; 
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__."/../../");
$dotenv->load();


use database\DatabaseConnectionManager;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Client {
    private $dbConnection;

    public function __construct() {
        $this->dbConnection = (new DatabaseConnectionManager())->getConnection();
    }


        public function read() {
        $query = "SELECT * FROM client";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getAllClients() {
        try {
            $query = "SELECT * FROM client ORDER BY client_name";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching clients: " . $e->getMessage());
            return [];
        }
    }

    public function getClientById($clientId) {
        try {
            $query = "SELECT * FROM client WHERE client_id = :client_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':client_id', $clientId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching client by ID: " . $e->getMessage());
            return null;
        }
    }

    public function getClientByName($clientName) {
        try {
            $query = "SELECT * FROM client WHERE client_name = :client_name";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':client_name', $clientName);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching client by name: " . $e->getMessage());
            return null;
        }
    }

    public function createClient($clientData) {
        try {
            $query = "INSERT INTO client (client_id, client_name) VALUES (:client_id, :client_name)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':client_id', $clientData['client_id']);
            $stmt->bindParam(':client_name', $clientData['client_name']);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error creating client: " . $e->getMessage());
            return false;
        }
    }

    public function updateClient($clientData) {
        try {
            $query = "UPDATE client SET client_name = :client_name WHERE client_id = :client_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':client_id', $clientData['client_id']);
            $stmt->bindParam(':client_name', $clientData['client_name']);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating client: " . $e->getMessage());
            return false;
        }
    }

    public function deleteClient($clientId) {
        try {
            $query = "DELETE FROM client WHERE client_id = :client_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':client_id', $clientId);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting client: " . $e->getMessage());
            return false;
        }
    }

    
    public function displayOptions($data){
        $html = "";
        
        foreach ($data as $client) {
          $html .=  "  <option value='{$client["client_name"]}'> {$client["client_name"]} </option> ";
        }
     
        return $html;
    }
    
    public function hasRelatedRecords($clientId) {
        try {
            // Check external_users table
            $query = "SELECT COUNT(*) FROM external_users WHERE client_id = :client_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':client_id', $clientId);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                return true;
            }

            // Check policy_data table
            $query = "SELECT COUNT(*) FROM policy_data WHERE client_id = :client_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':client_id', $clientId);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            error_log("Error checking related records: " . $e->getMessage());
            return true; // Assume there are related records to prevent deletion
        }
    }
}
