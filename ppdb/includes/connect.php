<?php
class Connection {
   private $conn;
    private $stmt;
    
    public function __construct(){
        $servername = "sql301.infinityfree.com";
		$database = "if0_37559960_smpiscensch_ppdb";
		$username = "if0_37559960";
		$password = "DvEPZKYZjrdi";
		//$password = "*123#IslamicCentre!";
        
        // Create connection
        $this->conn = mysqli_connect($servername, $username, $password, $database);
        
        // Check connection
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }
	
    public function getConnection() {
        return $this->conn;
    }
    
    public function closeConnection() {
        if ($this->stmt) {
            $this->stmt->close();
        }
        if ($this->conn) {
            $this->conn->close();
        }
    }
	
	public function closeStatement($stmt){
        
    }
}
$connection=new Connection();
?>