<?php
class Database {
    public $db;

    public function __construct(){ 
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=inventory;charset=utf8", "root", "");

        } catch(PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
}

?>