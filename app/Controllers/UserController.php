<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../Models/User.php';

require_once __DIR__ . '/../Core/Database/databaseconnectionmanager.php';
use database\DatabaseConnectionManager;

class UserController {
    private $dbConnection;

    public function __construct() {
        // Initialize the database connection
        $this->dbConnection = (new DatabaseConnectionManager())->getConnection();
    }

    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        echo json_encode($users);
    }
}

$dbConnection = (new DatabaseConnectionManager())->getConnection();
$query = "SELECT * FROM users";
$stmt = $this->dbConnection->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(\PDO::FETCH_ASSOC);

echo json_encode($users);

?>