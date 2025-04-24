<?php

namespace models;

use database\DatabaseConnectionManager;

class Bg_ternkey_report_schedule {

  private $insurance_start_date;
  private $insurance_end_date;
  private $booking_version_code;
  private $source;
  private $property_code;
  private $full_address;
  private $unit_number;
  private $city;
  private $premium;

  private $dbConnection;

  public function getInsuranceStartDate() {
    return $this->insurance_start_date;
  }

  public function setInsuranceStartDate($insurance_start_date) {
    $this->insurance_start_date = $insurance_start_date;
  }

  public function getInsuranceEndDate() {
    return $this->insurance_end_date;
  }

  public function setInsuranceEndDate($insurance_end_date) {
    $this->insurance_end_date = $insurance_end_date;
  }

  public function getBookingVersionCode() {
    return $this->booking_version_code;
  }

  public function setBookingVersionCode($booking_version_code) {
    $this->booking_version_code = $booking_version_code;
  }

  public function getSource() {
    return $this->source;
  }

  public function setSource($source) {
    $this->source = $source;
  }

  public function getPropertyCode() {
    return $this->property_code;
  }

  public function setPropertyCode($property_code) {
    $this->property_code = $property_code;
  }

  public function getFullAddress() {
    return $this->full_address;
  }

  public function setFullAddress($full_address) {
    $this->full_address = $full_address;
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

  public function premium() {
    return $this->premium;
  }

  public function setPremium($premium) {
    $this->premium = $premium;
  }

  public function readOne() {
    $query = "SELECT * FROM bg_ternkey_report_schedule WHERE booking_version_code = :booking _version_code";
    $stmt = $this->dbConnection->prepare($query);
    $stmt->bindParam(':booking_version_code', $this->booking_version_code);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_CLASS, Bg_ternkey_report_schedule::class);
  }

  public function read() {
    $query = "SELECT * FROM bg_ternkey_report_schedule";
    $stmt = $this->dbconnection->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
}
?>