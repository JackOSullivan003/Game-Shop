<?php include "connection.php"; 

class Cart {
    private $items = [];

    public function addProduct($product) {
        $this->items[$product->id] = $product;
    }

    public function removeProduct($productId) {
        if (array_key_exists($productId, $this->items)) {
            unset($this->items[$productId]);
        }
    }

    public function getTotalPrice() {
        $total = 0;
        foreach ($this->items as $product) {
            $total += $product->price;
        }
        return $total;
    }

    // Other methods for cart operations (e.g., apply discounts, checkout, etc.)
    //...
}


?>