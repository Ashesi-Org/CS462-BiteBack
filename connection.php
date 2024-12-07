<?php
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'ecomomentum';
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch(Exception $exception) {
            die("Connection error: " . $exception->getMessage());
        }

        return $this->conn;
    }

    // Method to sanitize input
    public function sanitize($input) {
        return htmlspecialchars(strip_tags($input));
    }
}
?>