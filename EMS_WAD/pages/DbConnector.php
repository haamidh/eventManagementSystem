<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


class DbConnector {
    private $host="localhost";
    private $user="root";
    private $password="";
    private $dbname="ems_wad_project";
    
    public function getConnection() {
        $dsn = "mysql:host=".$this->host.";dbname=".$this->dbname;
        try {
            $con = new PDO($dsn, $this->user, $this->password);
            return $con;
        } catch (PDOException $ex) {
            die("Connection failed".$ex->getMessage());
        }
    }
    
}
