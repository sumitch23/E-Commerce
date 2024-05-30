<?php 

class Dbhandler {
  private $host;
  private $user;
  private $pass;
  private $db;
  public $conn;

  public function __construct() {
    $this->connect();
  }

  private function connect() {
    
    $this->host = "127.0.0.1";
    $this->user = "root";
    $this->pass = "";
    $this->db = "ogtech";

    
    $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
    return $this->conn;

    
    if (!$this->conn) 
      die("Connection failed: " . mysqli_connect_error());
  }

  public function conn() {
    
    $this->conn = new mysqli("127.0.0.1", "root", "", "ogtech");
    return $this->conn;

    
    if (!$this->conn) 
      die("Connection failed: " . mysqli_connect_error());
  }
}