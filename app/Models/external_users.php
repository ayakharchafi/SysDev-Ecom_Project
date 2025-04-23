<?php
namespace models;

use database\DBConnectionManager;

class External_users {
    private $user_id;
    private $client_id;

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($id) {
        $this->user_id = $id;
    }   

    public function getClientId() {
        return $this->client_id;
    }

    public function setClientId($id) {
        $this->client_id = $id;
    } 

    public function readOne() {
        $query = "SELECT * FROM external_users WHERE user_id = :user_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, External_users::class);
    }

    public function read() {
        $query = "SELECT * FROM external_users";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>