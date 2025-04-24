<?php

namespace models;

use database\DatabaseConnectionManager;

class Policy_data {

    private $client_id;
    private $product_type;
    private $product_subtype;
    private $policy_number;
    private $policy_start_date;
    private $binding_authority;
    private $premium_rate;
    private $premium_basis;
    private $premium_prorated;
    private $premium_currency;

    public function getClientId() {
        return $this->client_id;
    }

    public function setClientId($client_id) {
        $this->client_id = $client_id;
    }

    public function getProductType() {
        return $this->product_type;
    }

    public function setProductType($product_type) {
        $this->product_type = $product_type;
    }

    public function getProductSubtype() {
        return $this->product_subtype;
    }

    public function setProductSubtype($product_subtype) {
        $this->product_subtype = $product_subtype;
    }

    public function getPolicyNumber() {
        return $this->policy_number;
    }

    public function setPolicyNumber($policy_number) {
        $this->policy_number = $policy_number;
    }

    public function getPolicyStartDate() {
        return $this->policy_start_date;
    }

    public function setPolicyStartDate($policy_start_date) {
        $this->policy_start_date = $policy_start_date;
    }

    public function getBindingAuthority() {
        return $this->binding_authority;
    }

    public function setBindingAuthority($binding_authority) {
        $this->binding_authority = $binding_authority;
    }

    public function getPremiumRate() {
        return $this->premium_rate;
    }

    public function setPremiumRate($premium_rate) {
        $this->premium_rate = $premium_rate;
    }

    public function getPremiumBasis() {
        return $this->premium_basis;
    }

    public function setPremiumBasis($premium_basis) {
        $this->premium_basis = $premium_basis;
    }

    public function getPremiumProrated() {
        return $this->premium_prorated;
    }

    public function setPremiumProrated($premium_prorated) {
        $this->premium_prorated = $premium_prorated;
    }

    public function getPremiumCurrency() {
        return $this->premium_currency;
    }

    public function setPremiumCurrency($premium_currency) {
        $this->premium_currency = $premium_currency;
    }

    public function readOne() {
        $query = "SELECT * FROM policy_data WHERE WHERE client_id = :client_id AND product_type = :product_type AND premium_currency = :premium_currency";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':client_id', $this->client_id);
        $stmt->bindParam(':product_type', $this->product_type);
        $stmt->bindParam(':premium_currency', $this->premium_currency);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Policy_data::class);
    }

    public function read() {
        $query = "SELECT * FROM policy_data";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>