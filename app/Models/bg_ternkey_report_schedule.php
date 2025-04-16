<?php

namespace models;

use database\DBConnectionManager;

class Bg_ternkey_report_schedule{

    private $id;
    private $insurance_start_date;
    private $insurance_end_date;
    private $booking_version_code;
    private $source;
    private $property_id;
    private $full_address;
    private $unit_number;
    private $city;
    private $nov_24;

      public function getId()
      {
          return $this->id;
      }
  
      public function setId($id)
      {
          $this->id = $id;
      }
  
      public function getInsuranceStartDate()
      {
          return $this->insurance_start_date;
      }
  
      public function setInsuranceStartDate($insurance_start_date)
      {
          $this->insurance_start_date = $insurance_start_date;
      }
  
      public function getInsuranceEndDate()
      {
          return $this->insurance_end_date;
      }
  
      public function setInsuranceEndDate($insurance_end_date)
      {
          $this->insurance_end_date = $insurance_end_date;
      }
  
      public function getBookingVersionCode()
      {
          return $this->booking_version_code;
      }
  
      public function setBookingVersionCode($booking_version_code)
      {
          $this->booking_version_code = $booking_version_code;
      }
  
      public function getSource()
      {
          return $this->source;
      }
  
      public function setSource($source)
      {
          $this->source = $source;
      }
  
      public function getPropertyId()
      {
          return $this->property_id;
      }
  
      public function setPropertyId($property_id)
      {
          $this->property_id = $property_id;
      }
  
      public function getFullAddress()
      {
          return $this->full_address;
      }
  
      public function setFullAddress($full_address)
      {
          $this->full_address = $full_address;
      }
  
      public function getUnitNumber()
      {
          return $this->unit_number;
      }
  
      public function setUnitNumber($unit_number)
      {
          $this->unit_number = $unit_number;
      }
  
      public function getCity()
      {
          return $this->city;
      }
  
      public function setCity($city)
      {
          $this->city = $city;
      }
  
      public function getNov24()
      {
          return $this->nov_24;
      }
  
      public function setNov24($nov_24)
      {
          $this->nov_24 = $nov_24;
      }
  }

    public function readOne() {
        $query = "SELECT * FROM bg_ternkey_report_schedule WHERE id = :reportID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':reportID', $this->id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Bg_ternkey_report_schedule::class);
    }

}
?>