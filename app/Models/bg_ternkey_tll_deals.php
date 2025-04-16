<?php

namespace models;

use database\DBConnectionManager;

class Bg_ternkey_tll_deals{
    private $booking_code;
    private $form_created_date;
    private $contract_sign_date;
    private $booking_version_code;

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

    public function readOne() {
        $query = "SELECT * FROM bg_ternkey_tll_deals WHERE id = :reportID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':reportID', $this->id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Bg_ternkey_tll_deals::class);
    }

}
?>