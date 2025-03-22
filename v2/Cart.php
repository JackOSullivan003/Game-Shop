<?php include "connection.php"; 

class Cart {
    //array of cart items
    private $items = [];

    //add cart items to the cart 
    public function addProduct($product) {
        $this->items[] = $product;
    }

    //remove cart items from the cart
    public function removeProduct($productId) {
        if (($key = array_search($productId, array_column($this->items, 'id')))!= false) {
            unset($this->items[$key]);
        }
    }

    //calculate total price of the cart
    public function getTotalPrice() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['price'];
        }
        return $total;
    }

    //get cart items
    public function getCartItems() {
        return $this->items;
    }

    
}


?>