<?php
class Database{
    private $host = "localhost";
    private $db_name = "housestuffdb";
    private $user = "root";
    private $password = "";
    public $conn;

    public function getConnection(){
        $this->conn = null;
        
        try{
            $this->conn = new  PDO("mysql:host:=" . $this->host . ";dbname=" . $this->db_name, $this->user, $this->password );
            $this->conn->exec("set names utf8");

        }catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;

    }
}
$database = new Database();
$db = $database->getConnection();



// CREATE TABLE products(
// 	id INT AUTO_INCREMENT PRIMARY KEY,
//     title VARCHAR(100) NOT NULL,
//     price DOUBLE NOT NULL,
//     category VARCHAR(255) NOT NULL,
//     img VARCHAR(255) NOT NULL,
//     description VARCHAR(255) NOT NULL,
//     fullDesc VARCHAR(500) NOT NULL,
    
//     FOREIGN KEY(category) REFERENCES categories(title)
// );

// CREATE TABLE admins (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     username VARCHAR(50) NOT NULL,
//     password VARCHAR(255) NOT NULL
// );


// CREATE TABLE categories (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     title VARCHAR(100) NOT NULL UNIQUE,
//     visible_title VARCHAR(100) NOT NULL

// );
