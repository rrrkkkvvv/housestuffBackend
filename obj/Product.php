<?php

class Product{
    private $conn;
    private $table_name = "products";

    public $id;
    public $title;
    public $img;
    public $description;
    public $fullDesc;
    public $price;
    public $category;

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
        $query = "INSERT INTO " . $this->table_name . " SET title = :title, description = :description, fullDesc = :fullDesc, price = :price, category = :category, img = :img";
        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->fullDesc = htmlspecialchars(strip_tags($this->fullDesc));
        $this->img = htmlspecialchars(strip_tags($this->img));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->category = htmlspecialchars(strip_tags($this->category));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':fullDesc', $this->fullDesc);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':img', $this->img);

        if ($stmt->execute()) {
            return true;
        }

        return false;   
    }
    function update(){
        $query = "UPDATE " . $this->table_name . " SET title = :title, description = :description, fullDesc = :fullDesc, price = :price, category = :category, img = :img WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->fullDesc = htmlspecialchars(strip_tags($this->fullDesc));
        $this->img = htmlspecialchars(strip_tags($this->img));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':fullDesc', $this->fullDesc);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':img', $this->img);
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