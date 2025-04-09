<?php 
class CartItem extends Product{

    private $Product; 

    public function __construct($Product) {
        $this->$Product = $Product;
    }
}
?>