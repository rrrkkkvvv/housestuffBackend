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
    function update(){
        $query = "UPDATE " . $this->table_name . " SET title = :title, visible_title = :visible_title WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->visible_title = htmlspecialchars(strip_tags($this->visible_title));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':visible_title', $this->visible_title);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;   
    }
    function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;   
    }
}