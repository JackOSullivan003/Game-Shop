<?php class CartItem extends Product {
    private $product; 
    private $quantity;
    private $totalprice;

    public function __construct($product, $quantity) {
        parent::__construct($product->id, $product->title, $product->description, $product->price, $product->image);
        $this->product = $product;
        $this->quantity = $quantity;
        $this->totalprice = $product->price * $quantity;
    }

    public function updateQuantity($newQuantity) {
        $this->quantity = $newQuantity;
        $this->totalprice = $this->product->price * $this->quantity;
    }

    
}