<?php
namespace models;

use database\DBConnectionManager;

class Bg_gl_insurance_schedule {

    private $bg_gl_id;
    private $property_city_code;
    private $property_code;
    private $property_building;
    private $property_address_full;
    private $property_address_apartment;
    private $premium;

    public function getId()
    {
        return $this->bg_gl_id;
    }
    
    public function setId($id)
    {
        $this->bg_gl_id = $id;
    }
    
    public function getPropertyCity()
    {
        return $this->property_city_code;
    }
    
    public function setPropertyCity($property_city_code)
    {
        $this->property_city_code = $property_city_code;
    }
    
    public function getPropertyCode()
    {
        return $this->property_code;
    }
    
    public function setPropertyCode($property_code)
    {
        $this->property_code = $property_code;
    }
    
    public function getPropertyBuilding()
    {
        return $this->property_building;
    }
    
    public function setPropertyBuilding($property_building)
    {
        $this->property_building = $property_building;
    }
    
    public function getPropertyAddressFull()
    {
        return $this->property_address_full;
    }
    
    public function setPropertyAddressFull($property_address_full)
    {
        $this->property_address_full = $property_address_full;
    }
    
    public function getPropertyAddressApartment()
    {
        return $this->property_address_apartment;
    }
    
    public function setPropertyAddressApartment($property_address_apartment)
    {
        $this->property_address_apartment = $property_address_apartment;
    }
    
    public function getPremium()
    {
        return $this->premium;
    }
    
    public function setPremium($premium)
    {
        $this->premium = $premium;
    }

    public function readOne() {
        $query = "SELECT * FROM bg_gl_insurance_schedule WHERE bg_gl_id = :bg_gl_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':bg_gl_id', $this->bg_gl_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Bg_gl_insurance_schedule::class);
    }

    public function read() {
        $query = "SELECT * FROM bg_gl_insurance_schedule";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>