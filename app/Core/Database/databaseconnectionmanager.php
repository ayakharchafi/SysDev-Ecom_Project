<?php

namespace database;

class DatabaseConnectionManager {

    private $username;
    private $password;
    private $server; 
    private $dbname;

    private $dbConnection;

    function __construct() {
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->server = $_ENV['DB_HOST'];
        $this->dbname = $_ENV['DB_DATABASE'];;

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