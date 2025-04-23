<?php
namespace models;

use database\DBConnectionManager;

class Super_user {
    private $user_id;

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($id) {
        $this->user_id = $id;
    }   

    public function read() {
        $query = "SELECT * FROM super_user";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>