<?php

class Db {

    private $servername = "localhost";

    private $dbname = "andonovs_ssp";

    private $username = "andonovs_ivan"; // "root"

    private $password = "**********";   // "";
    
    public $conn; 

    function __construct() {
        $this->conn = null;
		
        try{
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            $conn = null;
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
?>