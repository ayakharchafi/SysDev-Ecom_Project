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


    public function displayRecords($data){
        $html = "";
        $html .= '<table id="dataTable">';
        $html .= '<thead>';
        $html .= "<tr>";
        $html .= "<th>" . _('ID') . "</th>";
        $html .= "<th>" . _('Name') . "</th>";
        $html .= "<th>" . _('Email') . "</th>";
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

// API endpoint to retrieve all users from the database (used in main.js)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $users  = new UserController;
    $data = $users->read();
    echo $users->displayRecords($data);
}
?>