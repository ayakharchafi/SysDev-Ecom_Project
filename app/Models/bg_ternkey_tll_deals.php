<?php

namespace models;

use database\DatabaseConnectionManager;

class Bg_ternkey_tll_deals{
    private $booking_code;
    private $form_created_date;
    private $contract_sign_date;
    private $booking_version_code;
    private $city_code;
    private $property_code;
    private $start_date;
    private $end_date;

public function getBookingCode()
{
    return $this->booking_code;
}

public function setBookingCode($booking_code)
{
    $this->booking_code = $booking_code;
}

public function getFormCreatedDate()
{
    return $this->form_created_date;
}

public function setFormCreatedDate($form_created_date)
{
    $this->form_created_date = $form_created_date;
}

public function getContractSignDate()
{
    return $this->contract_sign_date;
}

public function setContractSignDate($contract_sign_date)
{
    $this->contract_sign_date = $contract_sign_date;
}

public function getBookingVersionCode()
{
    return $this->booking_version_code;
}

public function setBookingVersionCode($booking_version_code)
{
    $this->booking_version_code = $booking_version_code;
}

public function getCityCode() {
    return $this->city_code;
}

public function setCityCode($city_code) {
    $this->city_code = $city_code;
}

public function getPropertyCode() {
    return $this->property_code;
}

public function setPropertyCode($property_code) {
    $this->property_code = $property_code;
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

public function readOne() {
    $query = "SELECT * FROM bg_ternkey_tll_deals WHERE booking_version_code = :booking_version_code";
    $stmt = $this->dbConnection->prepare($query);
    $stmt->bindParam(':booking_version_code', $this->booking_version_code);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_CLASS, Bg_ternkey_tll_deals::class);
}

public function read() {
    $query = "SELECT * FROM bg_ternkey_tll_deals";
    $stmt = $this->dbconnection->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

}
?>