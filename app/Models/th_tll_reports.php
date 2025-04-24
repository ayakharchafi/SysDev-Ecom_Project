<?php

namespace models;

use database\DatabaseConnectionManager;

class Th_tll_reports {

    private $contract_file_name;
    private $contract_start_date;
    private $contract_end_date;
    private $monthly_billing_start_date;
    private $bill_end_date;
    private $month_end;
    private $property_id;
    private $property_name;
    private $unit_address;
    private $unit_number;
    private $city;
    private $state;
    private $zip;
    private $number_of_bill_days;
    private $cost;
    private $tax;
    private $total;

    private $dbConnection;

    public function getContractFileName() {
        return $this->contract_file_name;
    }
    
    public function setContractFileName($contract_file_name) {
        $this->contract_file_name = $contract_file_name;
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
    
    public function getMonthlyBillingStartDate() {
        return $this->monthly_billing_start_date;
    }
    
    public function setMonthlyBillingStartDate($monthly_billing_start_date) {
        $this->monthly_billing_start_date = $monthly_billing_start_date;
    }
    
    public function getBillEndDate() {
        return $this->bill_end_date;
    }
    
    public function setBillEndDate($bill_end_date) {
        $this->bill_end_date = $bill_end_date;
    }
    
    public function getMonthEnd() {
        return $this->month_end;
    }
    
    public function setMonthEnd($month_end) {
        $this->month_end = $month_end;
    }

    public function getPropertyId() {
        return $this->property_id;
    }

    public function setPropertyId($property_id) {
        $this->property_id = $property_id;
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
    
    public function getNumberOfBillDays() {
        return $this->number_of_bill_days;
    }
    
    public function setNumberOfBillDays($number_of_bill_days) {
        $this->number_of_bill_days = $number_of_bill_days;
    }
    
    public function getCost() {
        return $this->cost;
    }
    
    public function setCost($cost) {
        $this->cost = $cost;
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
        $query = "SELECT * FROM th_tll_reports WHERE contract_file_name = :contract_file_name";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':contract_file_name', $this->contract_file_name);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Th_tll_reports::class);
    }

    public function read() {
        $query = "SELECT * FROM th_tll_reports";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>