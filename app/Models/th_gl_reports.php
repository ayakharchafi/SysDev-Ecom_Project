<?php

namespace models;

use database\DBConnectionManager;

class Th_gl_reports {
    private $contract_file_name;
    private $contract_creation_date;
    private $contract_start_date;
    private $contract_end_date;
    private $property_id;
    private $property_management_id;
    private $property_name;
    private $unit_address;
    private $unit_number;
    private $city;
    private $state;
    private $zip;
    private $subtotal_per_unit;
    private $tax;
    private $total;

    public function getContractFileName() {
        return $this->contract_file_name;
    }

    public function setContractFileName($contract_file_name) {
        $this->contract_file_name = $contract_file_name;
    }

    public function getContractCreationDate() {
        return $this->contract_creation_date;
    }

    public function setContractCreationDate($contract_creation_date) {
        $this->contract_creation_date = $contract_creation_date;
    }

    public function getContractStartDate() {
        return $this->contract_start_date;
    }

    public function setContractStartDate($contract_start_date) {
        $this->contract_start_date = $contract_start_date;
    }

    public function getContractEndDate() {
        return $this->contract_end_date;
    }

    public function setContractEndDate($contract_end_date) {
        $this->contract_end_date = $contract_end_date;
    }

    public function getPropertyId() {
        return $this->property_id;
    }

    public function setPropertyId($property_id) {
        $this->property_id = $property_id;
    }

    public function getPropertyManagementId() {
        return $this->property_management_id;
    }

    public function setPropertyManagementId($property_management_id) {
        $this->property_management_id = $property_management_id;
    }

    public function getPropertyName() {
        return $this->property_name;
    }

    public function setPropertyName($property_name) {
        $this->property_name = $property_name;
    }

    public function getUnitAddress() {
        return $this->unit_address;
    }

    public function setUnitAddress($unit_address) {
        $this->unit_address = $unit_address;
    }

    public function getUnitNumber() {
        return $this->unit_number;
    }

    public function setUnitNumber($unit_number) {
        $this->unit_number = $unit_number;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function getZip() {
        return $this->zip;
    }

    public function setZip($zip) {
        $this->zip = $zip;
    }

    public function getSubtotalPerUnit() {
        return $this->subtotal_per_unit;
    }

    public function setSubtotalPerUnit($subtotal_per_unit) {
        $this->subtotal_per_unit = $subtotal_per_unit;
    }

    public function getTax() {
        return $this->tax;
    }

    public function setTax($tax) {
        $this->tax = $tax;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function readOne() {
        $query = "SELECT * FROM th_gl_reports WHERE contract_file_name = :contract_file_name";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':contract_file_name', $this->contract_file_name);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Th_gl_reports::class);
    }

    public function read() {
        $query = "SELECT * FROM th_gl_reports";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>