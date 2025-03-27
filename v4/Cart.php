<?php 
include 'classes/Product.php';

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
        }

        $_SESSION['cart'] = $this->items; // Update session
        //calculate total price 
        $this->getTotalPrice();
    }

    public function getTotalPrice() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        $_SESSION['total_cart_price'] = $total; // Update total price in session
        echo json_encode($_SESSION['total_cart_price']);
    }

    public function getCartItems() {
        return $this->items;
    }
}

?>
