<?php
namespace controllers;
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Core/Database/databaseconnectionmanager.php';
use models\User;
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

        return json_encode($users);
    }
    public function read() {
        $query = "SELECT * FROM users";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function readRoles() {
        $query = " SELECT users.`user_id` as user_id, `user_email`, `user_name`, `password`, external_users.client_id,enabled2FA FROM `users`
         left JOIN external_users ON users.user_id = external_users.user_id 
         left JOIN internal_users ON users.user_id = internal_users.user_id 
         ORDER BY `users`.`user_id`";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
 
    public function readExternal() {
        $query = "SELECT * FROM `users` INNER JOIN external_users ON users.user_id = external_users.user_id;";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function readInternal() {
        $query = "SELECT * FROM `users` INNER JOIN internal_users ON users.user_id = internal_users.user_id;";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function searchUsers($term) {
    $query = "SELECT * FROM users WHERE user_name LIKE :term OR user_email LIKE :term OR user_id LIKE :term";
    $stmt = $this->dbConnection->prepare($query);
    $searchTerm = "%" . $term . "%";

    // 👇 DEBUG LINE — REMOVE LATER
    error_log("Searching for: $searchTerm");

    $stmt->bindParam(':term', $searchTerm);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

    public function displayRecords($data){
        $html = "";
        $html .= '<table id="dataTable">';
        $html .= '<thead>';
        $html .= "<tr>";
        $html .= "<th>" . _('ID') . "</th>";
        $html .= "<th>" . _('Name') . "</th>";
        $html .= "<th>" . _('Email') . "</th>";
        $html .= "<th>" . _('Role') . "</th>";
        $html .= "<th>" . _('Enabled 2FA') . "</th>";
        $html .= "<th>" . _('Actions') . "</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody>";
        foreach ($data as $user) {
            $html .= "<tr>";
            $html .= "<td>{$user["user_id"]}</td>";
            $html .= "<td>{$user["user_name"]}</td>";
            $html .= "<td>{$user["user_email"]}</td>";
            if(isset($user["client_id"])){
                $html .= "<td>External</td>";
            }else{   
                    $html .= "<td>Internal</td>";
            }
            $html .= "<td>{$user["enabled2FA"]}</td>";
            $html .= "   <td>";
            $html .= "   <button class= 'action-btn'><i class= 'fa-solid fa-edit'></i></button>";
            $html .= "    <button class= 'action-btn'><i class= 'fa-solid fa-trash'></i></button>";
            $html .= "  </td>";
            $html .= "</tr>";
        }
        $html .= "</tbody>";
        $html .= "</table>";
        
        echo $html;
    }
}


// API endpoint to handle user search requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $users = new UserController();
    $searchTerm = $_GET['search'];
    $data = $users->searchUsers($searchTerm);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// API endpoint to get all users (for table loading)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['search'])) {
    $users = new UserController();
    $data = $users->read();
    echo $users->displayRecords($data);
    exit;
}
?>