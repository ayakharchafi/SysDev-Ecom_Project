<?php
namespace models;

use database\DBConnectionManager;

class Bg_tl_reports{

    private $id;
    private $property_city;
    private $property_code;
    private $property_building;
    private $property_address_full;
    private $property_address_apartement;
    private $nov_24;

    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getPropertyCity()
    {
        return $this->property_city;
    }
    
    public function setPropertyCity($property_city)
    {
        $this->property_city = $property_city;
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
    
    public function getPropertyAddressApartement()
    {
        return $this->property_address_apartement;
    }
    
    public function setPropertyAddressApartement($property_address_apartement)
    {
        $this->property_address_apartement = $property_address_apartement;
    }
    
    public function getNov24()
    {
        return $this->nov_24;
    }
    
    public function setNov24($nov_24)
    {
        $this->nov_24 = $nov_24;
    }

    public function readOne() {
        $query = "SELECT * FROM bg_tl_reports WHERE id = :reportID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':reportID', $this->id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Bg_tl_reports::class);
    }

}
?>