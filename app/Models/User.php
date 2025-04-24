<?php
namespace models;

use Database\DatabaseConnectionManager;

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

    public function readByUsername() {
        $query = "SELECT * FROM users WHERE user_name = :username";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, User::class);
    }

    public function read() {
        $query = "SELECT * FROM users";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create() {
        if (empty($this->username) && empty($this->password)) {
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

    public function verifyCredentials($username, $password)
    {
        return isset($this->validUsers[$username]) && 
               $this->validUsers[$username] === $password;
    }
}

?>