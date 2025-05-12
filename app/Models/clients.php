<?php

namespace models;

use database\DatabaseConnectionManager;


class Clients {
    private $client_id;
    private $client_name;

    private $dbConnection;

    public function getClientId() {
        return $this->client_id;
    }

    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    public function getClientName()
    {
        return $this->client_name;
    }

    public function setClientName($client_name)
    {
        $this->client_name = $client_name;
    }

    public function readOne() {
        $query = "SELECT * FROM clients WHERE WHERE client_id = :client_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':client_id', $this->client_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Clients::class);
    }

    public function read() {
        $query = "SELECT * FROM clients";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>