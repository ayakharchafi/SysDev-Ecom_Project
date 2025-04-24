<?php

namespace models;

use database\DatabaseConnectionManager;

class Bg_tll_property_facts {

    private $property_code;
    private $address_full;
    private $address_apt;

    private $dbConnection;

  
    public function getPropertyCode() {
        return $this->property_code;
    }

    public function setPropertyCode($property_code) {
        $this->property_code = $property_code;
    }

    public function getAddressFull() {
        return $this->address_full;
    }

    public function setAddressFull($address_full) {
        $this->address_full = $address_full;
    }

    public function getAddressApt() {
        return $this->unit_number;
    }

    public function setAddressApt($address_apt) {
        $this->address_apt = $address_apt;
    }

    public function readOne() {
        $query = "SELECT * FROM bg_tll_property_facts WHERE property_code = :property_code";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':property_code', $this->property_code);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Bg_tll_property_facts::class);
    }

    public function read() {
        $query = "SELECT * FROM bg_tll_property_facts";
        $stmt = $this->dbconnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>