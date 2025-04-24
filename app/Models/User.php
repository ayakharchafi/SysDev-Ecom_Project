<?php
namespace models;
require_once __DIR__ . '/../Core/Database/databaseconnectionmanager.php';
use database\DatabaseConnectionManager;

class User {
    private $user_id;
    private $user_email;
    private $user_name;
    private $password;

    private $dbConnection;

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($id) {
        $this->user_id = $id;
    }    

    public function getUsername() {
        return $this->user_name;
    }

    public function setUsername($username) {
        $this->user_name = $username;
    }    

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function __construct() {
        $this->dbConnection = (new DatabaseConnectionManager())->getConnection();
    }

    public function readOne() {
        $query = "SELECT * FROM users WHERE user_id = :user_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, User::class);
    }

    public function readByUsername($username) {
        $query = "SELECT * FROM users WHERE user_name = :username";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($user) {
            $this->user_name = $user['user_name'];
            $this->password = $user['password'];
            $this->user_id = $user['user_id'];
            $this->user_email = $user['user_email'];
        }
    
        return $user;
    }

    public function read() {
        $query = "SELECT * FROM users";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create() {
        if (empty($this->user_name) && empty($this->password)) {
            return false;
        }

        $query = "INSERT INTO users (user_name, password) VALUES (:user_name, :password)";
        $stmt = $this->dbConnection->prepare($query);

        $stmt->bindParam(':user_name', $this->user_name);
        $stmt->bindParam(':password', $this->password);

        return $stmt->execute();
    }

    private $validUsers = [
        'demo' => 'demo123' // username => password
    ];

    public function verifyCredentials($password) {
        $isVerified = password_verify(trim($password), $this->password); // Store the result once
    
        if ($isVerified) {
            $_SESSION['user_id'] = $this->user_id; // Use $this->user_id properly
            return true;
        } else {
            $_SESSION['error'] = "Invalid username or password.";
            return false;
        }
    }
}

?>