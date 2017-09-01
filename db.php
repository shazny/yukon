<?php


// Singleton to connect db.
class ConnectDb {
  // Hold the class instance.
  private static $instance = null;
  private $conn;
  
  private $host = 'localhost';
  private $user = 'root';
  private $pass = '1234';
  private $name = 'yukon';
   
  // The db connection is established in the private constructor.
  private function __construct()
  {
   // $this->conn = new PDO("mysql:host={$this->host};
   // dbname={$this->name}", $this->user,$this->pass,
   // array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

    $this->conn=mysqli_connect($this->host,$this->user,$this->pass,$this->name);
    //$conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

  }
  
  public static function getInstance()
  {
    if(!self::$instance)
    {
      self::$instance = new ConnectDb();
    }
   
    return self::$instance;
  }
  
  public function getConnection()
  {
    return $this->conn;
  }
}

?>