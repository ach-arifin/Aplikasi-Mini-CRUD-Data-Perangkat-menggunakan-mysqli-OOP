<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "db_perangkat";
    
    public $conn;

    public function __construct() {
        $this->conn = new mysqli(
            $this->host,
            $this->user,
            $this->password,
            $this->dbname
        );

        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }
}
?>
