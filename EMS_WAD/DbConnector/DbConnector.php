<?php

class DbConnector
{
    private $serverName = 'localhost';
    private $databaseName = 'ems_wad_project';
    private $userName = 'root';
    private $password = '';

    public function connect()
    {
        try {
            $conn = new PDO("mysql:host=$this->serverName;dbname=$this->databaseName", $this->userName, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $ex) {
            echo 'connection failed..!!!' + $ex;
        }
    }
}
