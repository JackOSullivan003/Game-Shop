<?php
session_start();
include 'util/Connection.php';
include 'Cart.php';

// Get database connection
$conn = Connection::getConnection();

// Get product ID from URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Fetch product details
$productRequest = "SELECT product_id, product_name, description, price FROM Products WHERE product_id = $id";
$productResult = mysqli_query($conn, $productRequest);

$product = mysqli_fetch_assoc($productResult) ?: null;

// Initialize Cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Process "Add to Cart" action
if (isset($_GET['action']) && $_GET['action'] === 'addtocart') {
    // Get product_id and quantity
    if (!isset($_GET['id']) || !isset($_GET['quantity'])) {
        echo json_encode(['success' => false, 'message' => 'Missing product_id or quantity']);
        exit;
    }

    $product_id = (int)$_GET['id'];
    $quantity = (int)$_GET['quantity'];

    // Validate quantity
    if ($quantity <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid quantity']);
        exit;
    }

    if ($product) {
        $productId = $product['product_id'];

        // Check if item is already in cart
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'id' => $product['product_id'],
                'title' => $product['product_name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        }

        // Respond with a success message
        echo json_encode(['success' => true, 'message' => 'Item added to cart successfully', 'cartCount' => count($_SESSION['cart'])]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
    }
    
    exit;
}
?>

<!DOCTYPE html>
<html>
    <script>
        function updateQuantity(change) {
            qtyinput = document.getElementById('quantity');
            let quantity = parseInt(qtyinput.value);
            quantity += change;
            if (quantity < 1) quantity = 1;
            qtyinput.value = quantity;
        }
    
        function addToCart(productId) {
            qtyinput = document.getElementById('quantity');
            let quantity = qtyinput.value;
            fetch(`?action=addtocart&id=${productId}&quantity=${quantity}`)
            .then(response => {
                // Log the entire response for debugging purposes
                console.log("Response from PHP:", response);

                // Check if response is valid JSON
                return response.json();
            })
            .then(data => {
                console.log("Data from PHP:", data);  // Log the parsed response data

                if (data.success) {
                    // Display "Added to Cart" message
                    document.getElementById('cart-message').style.display = 'block';
                    setTimeout(() => document.getElementById('cart-message').style.display = 'none', 2000);

                    // Optionally, update UI or perform other actions based on the response
                    console.log('Item added to cart:', data.message);
                    //reload the cart number 
                    document.getElementById('cartCount').innerHTML = data.cartCount;
                } else {
                    // Handle error case
                    alert(data.message); // Show message in alert box if something went wrong
                }
            })
            .catch(error => {
                console.log('Error:', error);
                alert('An error occurred while adding to cart');
            });
        }
    </script>

    <?php include 'Header.php'; ?>
    <link rel="stylesheet" href="css/product.css" type="text/css">

    <section class="products-section">
        <?php if ($product): ?>
            <div class="product">
                <!-- Left: Product Image -->
                <div class="product-image">
                    <img src="util/display_image.php?image_id=<?= $product['product_id']; ?>">
                </div>

                <!-- Middle: Description -->
                <div class="product-description">
                    <h1 class="product-title"><?= htmlspecialchars($product['product_name']); ?></h1>
                    <p><?= htmlspecialchars($product['description']); ?></p>
                </div>

                <!-- Right: Price, Quantity, and Buy Button -->
                <div class="product-details">
                    <p class="product-price">$<?= $product['price']; ?></p>

                    <!-- Quantity Selector -->
                    <div class="quantity-selector">
                        <button type="button" onclick="updateQuantity(-1)">-</button>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="100">
                        <button type="button" onclick="updateQuantity(1)">+</button>
                    </div>

                    <!-- "Added to Cart" Message -->
                    <p class="cart-message" id="cart-message" style="display: none;">Added to Cart!</p>

                    <!-- Buy Button -->
                    <button href="#" class="buy-button" onclick="addToCart(<?= $product['product_id'];?>)">Add to Cart</button>
                </div>
            </div>

            <?php else: ?>
                <div class="product">
                    <p>Product not found.</p>
                </div>
            <?php endif; ?>
    </section>

    <?php include 'Review.php'; ?>

    <footer>
        <p>&copy; 2025 Game & Stop</p>
        <a class="social-media-link" href="#"><i class="fa fa-facebook"></i></a>
        <a class="social-media-link" href="#"><i class="fa fa-twitter"></i></a>
    </footer>

</html>
