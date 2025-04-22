<?php
namespace models;

use database\DBConnectionManager;

class User {
private $id;
private $username;
private $password;
private $isInternal;
private $isSuper;

    // Getters and setters

    public function getID() {
        return $this->id;
    }

    public function setID($id) {
        $this->id = $id;
    }    


    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }    

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function __construct() {
        $this->dbConnection = (new DBConnectionManager())->getConnection();
    }

    public function readOne() {
        $query = "SELECT * FROM users WHERE id = :userID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':userID', $this->id);
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

    public function create() {
        if (empty($this->username) && empty($this->password)) {
            return false;
        }

        $query = "INSERT INTO users (user_name, password) VALUES (:username, :password)";
        $stmt = $this->dbConnection->prepare($query);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);

        return $stmt->execute();
    }
    

    public function getIsInternal() {
        return $this->isInternal;
    }

    public function setIsInternal($isInternal) {
        $this->isInternal = $isInternal;
    }  

    public function getIsSuper() {
        return $this->isSuper;
    }

    public function setIsSuper($isSuper) {
        $this->isSuper = $isSuper;
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

class Admin extends User {
    //
}

class ExternalEmployee extends User {
    private $client;

    // External employees can only access policy tables pretaining to their own company
    public function canView($policy) {
        return $this->client == $policy->getClient();
    }
}
?>