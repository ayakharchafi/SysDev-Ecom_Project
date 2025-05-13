<?php
namespace controllers;
require_once __DIR__ . '/../Core/Database/databaseconnectionmanager.php';
use database\DatabaseConnectionManager;

class ArchivedClientController {
    private $db;
    public function __construct(){
        $this->db = (new DatabaseConnectionManager())->getConnection();
    }

    // $ids = [1,2,3]
    public function archiveClients(array $ids): int {
        if (empty($ids)) return 0;
        // Move out of mk table
        $in  = str_repeat('?,', count($ids)-1) . '?';
        $this->db->beginTransaction();
        // 1) copy rows
        $copySql = "INSERT INTO archived_clients SELECT * FROM mk_occupancy_reports WHERE id IN ($in)";
        $stmt1 = $this->db->prepare($copySql);
        $stmt1->execute($ids);
        // 2) delete originals
        $delSql  = "DELETE FROM mk_occupancy_reports WHERE id IN ($in)";
        $stmt2 = $this->db->prepare($delSql);
        $stmt2->execute($ids);
        $this->db->commit();
        return $stmt2->rowCount();
    }

    public function restoreClients(array $ids): int {
        if (empty($ids)) return 0;
        $in  = str_repeat('?,', count($ids)-1) . '?';
        $this->db->beginTransaction();
        // 1) copy back
        $copySql = "INSERT INTO mk_occupancy_reports SELECT * FROM archived_clients WHERE id IN ($in)";
        $stmt1 = $this->db->prepare($copySql);
        $stmt1->execute($ids);
        // 2) delete from archived
        $delSql  = "DELETE FROM archived_clients WHERE id IN ($in)";
        $stmt2 = $this->db->prepare($delSql);
        $stmt2->execute($ids);
        $this->db->commit();
        return $stmt2->rowCount();
    }
}
