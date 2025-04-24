<?php
namespace models;

use database\DatabaseConnectionManager;

class Internal_users {
    private $user_id;

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($id) {
        $this->user_id = $id;
    }   

    public function readOne() {
        $query = "SELECT * FROM internal_users WHERE user_id = :user_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Internal_users::class);
    }

    public function read() {
        $query = "SELECT * FROM internal_users";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>