<?php

namespace models;

use database\DBConnectionManager;

class Mk_occupancy_reports {
    private $mk_occupancy_reports_id;
    private $location_id;
    private $first_date_of_coverage;
    private $last_date_of_coverage;
    private $location_address;
    private $location_postal_code;
    private $location_city;
    private $location_province;
    private $number_of_bedrooms;
    private $number_of_days_occupied;
    private $currency;
    private $premium_collected;

    public function getMKOccupancyReportsId() {
        return $this->mk_occupancy_reports_id;
    }

    public function setMKOccupancyReportsId($mk_occupancy_reports_id) {
        $this->mk_occupancy_reports_id = $mk_occupancy_reports_id;
    }

    public function getLocationId() {
        return $this->location_id;
    }

    public function setLocationId($location_id) {
        $this->location_id = $location_id;
    }

    public function getFirstDateOfCoverage() {
        return $this->first_date_of_coverage;
    }

    public function setFirstDateOfCoverage($first_date_of_coverage) {
        $this->first_date_of_coverage = $first_date_of_coverage;
    }

    public function getLastDateOfCoverage() {
        return $this->last_date_of_coverage;
    }

    public function setLastDateOfCoverage($last_date_of_coverage) {
        $this->last_date_of_coverage = $last_date_of_coverage;
    }

    public function getLocationAddress() {
        return $this->location_address;
    }

    public function setLocationAddress($location_address) {
        $this->location_address = $location_address;
    }

    public function getLocationPostalCode() {
        return $this->location_postal_code;
    }

    public function setLocationPostalCode($location_postal_code) {
        $this->location_postal_code = $location_postal_code;
    }

    public function getLocationCity() {
        return $this->location_city;
    }

    public function setLocationCity($location_city) {
        $this->location_city = $location_city;
    }

    public function getLocationProvince() {
        return $this->location_province;
    }

    public function setLocationProvince($location_province) {
        $this->location_province = $location_province;
    }

    public function getNumberOfBedrooms() {
        return $this->number_of_bedrooms;
    }

    public function setNumberOfBedrooms($number_of_bedrooms) {
        $this->number_of_bedrooms = $number_of_bedrooms;
    }

    public function getNumberOfDaysOccupied() {
        return $this->number_of_days_occupied;
    }

    public function setNumberOfDaysOccupied($number_of_days_occupied) {
        $this->number_of_days_occupied = $number_of_days_occupied;
    }

    public function getCurrency() {
        return $this->currency;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    public function getPremiumCollected() {
        return $this->premium_collected;
    }

    public function setPremiumCollected($premium_collected) {
        $this->premium_collected = $premium_collected;
    }

    public function readOne() {
        $query = "SELECT * FROM mk_occupancy_reports WHERE mk_occupancy_reports_id = :mk_occupancy_reports_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':mk_occupancy_reports_id', $this->mk_occupancy_reports_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Mk_occupancy_reports::class);
    }

    public function read() {
        $query = "SELECT * FROM mk_occupancy_reports";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}