<?php class Product {
    private $id; 
    private $title; 
    private $description;
    private $genre; 
    private $condition; 
    private $price;
    private $image;


    public function __construct($id, $title, $description, $genre, $condition, $price, $image) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->$genre;
        $this->price = $price;
        $this->image = $image;
    }

    // Getters and setters for product properties
    
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getImage() {
        return $this->image;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setImage($image) {
        $this->image = $image;
    }


    
}

?>