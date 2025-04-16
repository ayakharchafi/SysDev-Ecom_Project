<?php

namespace models;

use database\DBConnectionManager;


class Client{
    private $id;
    private $name;
    private $product_type;
    private $product_subtype;
    private $policy_number;
    private $policy_start_date;
    private $binding_auth;
    private $premium_rate;
    private $basis;
    private $prorated;
    private $currency;

public function getId()
{
    return $this->id;
}

public function setId($id)
{
    $this->id = $id;
}

public function getName()
{
    return $this->name;
}

public function setName($name)
{
    $this->name = $name;
}

public function getProductType()
{
    return $this->product_type;
}

public function setProductType($product_type)
{
    $this->product_type = $product_type;
}

public function getProductSubtype()
{
    return $this->product_subtype;
}

public function setProductSubtype($product_subtype)
{
    $this->product_subtype = $product_subtype;
}

public function getPolicyNumber()
{
    return $this->policy_number;
}

public function setPolicyNumber($policy_number)
{
    $this->policy_number = $policy_number;
}

public function getPolicyStartDate()
{
    return $this->policy_start_date;
}

public function setPolicyStartDate($policy_start_date)
{
    $this->policy_start_date = $policy_start_date;
}

public function getBindingAuth()
{
    return $this->binding_auth;
}

public function setBindingAuth($binding_auth)
{
    $this->binding_auth = $binding_auth;
}

public function getPremiumRate()
{
    return $this->premium_rate;
}

public function setPremiumRate($premium_rate)
{
    $this->premium_rate = $premium_rate;
}

public function getBasis()
{
    return $this->basis;
}

public function setBasis($basis)
{
    $this->basis = $basis;
}

public function getProrated()
{
    return $this->prorated;
}

public function setProrated($prorated)
{
    $this->prorated = $prorated;
}

public function getCurrency()
{
    return $this->currency;
}

public function setCurrency($currency)
{
    $this->currency = $currency;
}

    public function readOne() {
        $query = "SELECT * FROM client WHERE id = :clientID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':clientID', $this->id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Client::class);
    }

}
?>