<?php

class User {
    protected $id;
    protected $username;
    protected $password;
    protected $enabled2FA;
    protected $secret;
    protected $dbConnection;

    public function __construct($username = null, $password = null) {
        $this->username = $username;
        $this->password = $password;
        $this->dbConnection = (new DBConnectionManager())->getConnection();
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

    public function getenabled2FA() {
        return $this->enabled2FA;
    }

    public function setenabled2FA($enabled2FA) {
        $this->enabled2FA = $enabled2FA;
    }    

    public function getSecret() {
        return $this->secret;
    }

    public function setSecret($secret) {
        $this->secret = $secret;
    }    

    public function getID() {
        return $this->id;
    }

    public function setID($id) {
        $this->id = $id;
    }

    public function readOne() {
        $query = "SELECT * FROM users WHERE id = :userID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':userID', $this->id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, User::class);
    }

    public function readByUsername() {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, User::class);
    }

    public function create() {
        if (empty($this->username) && empty($this->password)) {
            return false;
        }

        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $this->dbConnection->prepare($query);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);

        return $stmt->execute();
    }

    // Plain text credentials
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