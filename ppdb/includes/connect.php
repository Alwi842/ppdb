<?php
class Connection {
   private $conn;
    private $stmt;
    
    public function __construct(){
        $servername = "localhost";
		$database = "ppdb";
		$username = "admin";
		$password = "";
        
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
