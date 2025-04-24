<?php

namespace models;

use database\DatabaseConnectionManager;

class Bg_ternkey_tll_insurance_data{

    private $city_code;
    private $booking_code;
    private $start_date;
    private $end_date;
    private $client_insurance;
    private $booking_version_code;

    private $dbConnection;

    public function getCityCode() {
        return $this->city_code;
    }

    public function setCityCode($city_code) {
        $this->city_code = $city_code;
    }

    public function getBookingCode() {
        return $this->booking_code;
    }

    public function setBookingCode($booking_code) {
        $this->booking_code = $booking_code;
    }

    public function getStartDate() {
        return $this->start_date;
    }

    public function setStartDate($start_date) {
        $this->start_date = $start_date;
    }

    public function getEndDate() {
        return $this->end_date;
    }

    public function setEndDate($end_date) {
        $this->end_date = $end_date;
    }

    public function getClientInsurance() {
        return $this->client_insurance;
    }

    public function setClientInsurance($client_insurance) {
        $this->client_insurance = $client_insurance;
    }

    public function getBookingVersionCode() {
        return $this->booking_version_code;
    }

    public function setBookingVersionCode($booking_version_code) {
        $this->booking_version_code = $booking_version_code;
    }

    public function readOne() {
        $query = "SELECT * FROM bg_ternkey_tll_insurance_data WHERE booking_version_code = :booking_version_code";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':booking_version_code', $this->booking_version_code);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Bg_ternkey_tll_insurance_data::class);
    }

    public function read() {
        $query = "SELECT * FROM bg_ternkey_tll_insurance_data";
        $stmt = $this->dbconnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>