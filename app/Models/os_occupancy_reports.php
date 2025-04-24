<?php

namespace models;

use database\DatabaseConnectionManager;

class Os_occupancy_reports {
    private $os_occupancy_reports_id;
    private $guest_arrival_date;
    private $guest_depart_date;
    private $guest_name;
    private $client_name;
    private $city;
    private $state;
    private $unit_address;
    private $apt_start_date;
    private $original_apt_start_date;
    private $final_apt_start_date;
    private $domestic_or_international;
    private $days_occupied;
    private $shletern_oasis_coverage;
    private $ternkey_tenant_coverage;

    public function getId() {
        return $this->os_occupancy_reports_id;
    }

    public function setId($id) {
        $this->os_occupancy_reports_id = $id;
    }

    public function getGuestArrivalDate() {
        return $this->guest_arrival_date;
    }

    public function setGuestArrivalDate($guest_arrival_date) {
        $this->guest_arrival_date = $guest_arrival_date;
    }

    public function getGuestDepartDate() {
        return $this->guest_depart_date;
    }

    public function setGuestDepartDate($guest_depart_date) {
        $this->guest_depart_date = $guest_depart_date;
    }

    public function getGuestName() {
        return $this->guest_name;
    }

    public function setGuestName($guest_name) {
        $this->guest_name = $guest_name;
    }

    public function getClientName() {
        return $this->client_name;
    }

    public function setClientName($client_name) {
        $this->client_name = $client_name;
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

    public function getUnitAddress() {
        return $this->unit_address;
    }

    public function setUnitAddress($unit_address) {
        $this->unit_address = $unit_address;
    }

    public function getAptStartDate() {
        return $this->apt_start_date;
    }

    public function setAptStartDate($apt_start_date) {
        $this->apt_start_date = $apt_start_date;
    }

    public function getOriginalAptStartDate() {
        return $this->original_apt_start_date;
    }

    public function setOriginalAptStartDate($original_apt_start_date) {
        $this->original_apt_start_date = $original_apt_start_date;
    }

    public function getFinalAptStartDate() {
        return $this->final_apt_start_date;
    }

    public function setFinalAptStartDate($final_apt_start_date) {
        $this->final_apt_start_date = $final_apt_start_date;
    }

    public function getDomesticOrInternational() {
        return $this->domestic_or_international;
    }

    public function setDomesticOrInternational($domestic_or_international) {
        $this->domestic_or_international = $domestic_or_international;
    }

    public function getDaysOccupied() {
        return $this->days_occupied;
    }

    public function setDaysOccupied($days_occupied) {
        $this->days_occupied = $days_occupied;
    }

    public function getShelternOasisCoverage() {
        return $this->sheltern_oasis_coverage;
    }

    public function setShelternOasisCoverage($sheltern_oasis_coverage) {
        $this->sheltern_oasis_coverage = $sheltern_oasis_coverage;
    }

    public function getTernkeyTenantCoverage() {
        return $this->ternkey_tenant_coverage;
    }

    public function setTernkeyTenantCoverage($ternkey_tenant_coverage) {
        $this->ternkey_tenant_coverage = $ternkey_tenant_coverage;
    }

    public function readOne() {
        $query = "SELECT * FROM os_occupancy_reports WHERE os_occupancy_reports_id = :os_occupancy_reports_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':os_occupancy_reports_id', $this->os_occupancy_reports_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Os_occupancy_reports::class);
    }

    public function read() {
        $query = "SELECT * FROM os_occupancy_reports";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>