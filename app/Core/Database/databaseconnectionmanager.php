<?php

namespace Database;

class DatabaseConnectionManager {

    private $username;
    private $password; // password to be stored and read through an environment variable
    private $server; 
    private $dbname;

    private $dbConnection;

    function __construct() {

        // username/password etc not yet determined
        $this->username = ""; 
        $this->password = "";
        $this->server = "";
        $this->dbname = "";

        try {
        
            $this->dbConnection = new \PDO("mysql:host=$this->server;dbname=$this->dbname", $this->username, $this->password);

        } catch(\PDOException $e) {
            print "Error: " . $e->getMessage() . "<br/>";
        }
    }

    function getConnection() {
        return $this->dbConnection;
    }   
    
}