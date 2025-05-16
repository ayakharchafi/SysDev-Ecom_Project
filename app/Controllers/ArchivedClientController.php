<?php
namespace controllers;
require_once __DIR__ . '/../Core/Database/databaseconnectionmanager.php';
use database\DatabaseConnectionManager;
class ArchivedClientController {
    private $dbConnection;
    public function __construct(){
        $this->dbConnection = (new DatabaseConnectionManager())->getConnection();
    }
    public function archiveClients(array $ids): int {
        if (empty($ids)) return 0;
        $in  = str_repeat('?,', count($ids)-1) . '?';
        $this->dbConnection->beginTransaction();
        // its going to copy the same rows of mk clients to archived clients in the display
        $copySql = "INSERT INTO archived_clients SELECT * FROM mk_occupancy_reports WHERE id IN ($in)";
        $stmt1 = $this->dbConnection->prepare($copySql);
        $stmt1->execute($ids);
        // after copying this deletes the client from mk clients so that they arent in both tables
        $delSql  = "DELETE FROM mk_occupancy_reports WHERE id IN ($in)";
        $stmt2 = $this->dbConnection->prepare($delSql);
        $stmt2->execute($ids);
        $this->dbConnection->commit();
        return $stmt2->rowCount();
    }
    public function restoreClients(array $ids): int {
        if (empty($ids)) return 0;
        $in  = str_repeat('?,', count($ids)-1) . '?';
        $this->dbConnection->beginTransaction();
        // copy back the archived client info to the mk tables 
        $copySql = "INSERT INTO mk_occupancy_reports SELECT * FROM archived_clients WHERE id IN ($in)";
        $stmt1 = $this->dbConnection->prepare($copySql);
        $stmt1->execute($ids);
        // removes it from the archived client table
        $delSql  = "DELETE FROM archived_clients WHERE id IN ($in)";
        $stmt2 = $this->dbConnection->prepare($delSql);
        $stmt2->execute($ids);
        $this->dbConnection->commit();
        return $stmt2->rowCount();
    }
       public function read() {
       $query = "SELECT * FROM archived_clients";
       $stmt = $this->dbConnection->prepare($query);
       $stmt->execute();
       return $stmt->fetchAll(\PDO::FETCH_ASSOC);
   }
      public function displayClientsMK($data) {
       $html = "";
       foreach ($data as $client) {
           $html .= "<tr>";
           $html .= "<td ><input class = 'tbCB' type='checkbox'><td>";
           $html .= "<td id = idBox>{$client["id"]}</td>";
           $html .= "<td>{$client["location_id"]}</td>";
           $html .= "<td>{$client["location_address"]}</td>";
           $html .= "<td>{$client["location_city"]}, {$client["location_province"]}</td>";
           $html .= "<td>{$client["first_date_of_coverage"]}</td>";
           $html .= "<td>{$client["last_date_of_coverage"]}</td>";
           $html .= "<td>{$client["currency"]} {$client["premium_collected"]}</td>";
           $html .= "<td>";
           $html .= "<button class='action-btn edit-btn' data-id='{$client["id"]}'><i class='fa-solid fa-edit'></i></button>";
           $html .= "<button class='action-btn delete-btn' data-id='{$client["id"]}'><i class='fa-solid fa-trash'></i></button>";
           $html .= "</td>";
           $html .= "</tr>";
       }
       if (empty($data)) {
           $html .= "<tr><td colspan='8' class='text-center'>No clients found</td></tr>";
       }
       return $html;
    }
}