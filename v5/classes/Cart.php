<?php 
include 'Product.php';

class Cart {
    private $items = [];
    public function __construct() {
        // Ensure session cart exists and is an array
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $this->items = $_SESSION['cart'];
    }

    public function addProduct($product, $quantity = 1) {
        $productId = $product['product_id'];

        if (isset($this->items[$productId])) {
            $this->items[$productId]['quantity'] += $quantity;
        } else {
            $this->items[$productId] = [
                'id' => $product['product_id'],
                'title' => $product['product_name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        }

        $_SESSION['cart'] = $this->items; // Save items to session
        $this->getTotalPrice();
    }

    public function removeProduct($productId) {
        if (isset($this->items[$productId])) {
            unset($this->items[$productId]);
            $_SESSION['cart'] = $this->items; // Save it back to session
        }
    
        // Update session and calculate total price
        $_SESSION['cart'] = $this->items;
        $this->getTotalPrice();
    }

    public function getTotalPrice() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total; 
    }

    public function getCartItems() {
        return $this->items;
    }

    public function clearCart()
    {
        $this->items = [];
        $_SESSION['cart'] = [];
    }
}

?>
