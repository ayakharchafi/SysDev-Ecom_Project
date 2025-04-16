<?php
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

    // Plain text credentials
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