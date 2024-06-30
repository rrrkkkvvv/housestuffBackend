<?php

class Category{
    private $conn;
    private $table_name = "categories";

    public $id;
    public $title;
    public $visible_title;

    public function __construct($db) {
        $this->conn = $db;
        
    }
    function get(){
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function create(){
        $query = "INSERT INTO " . $this->table_name . " SET title = :title, visible_title = :visible_title";
        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->visible_title = htmlspecialchars(strip_tags($this->visible_title));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':visible_title', $this->visible_title);


        if ($stmt->execute()) {
            return true;
        }

        return false;   
    }
}