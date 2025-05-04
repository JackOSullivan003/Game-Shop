<?php
session_start();
include 'util/Connection.php';
include 'classes/Cart.php';

// Get product ID from URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Fetch product details
$productRequest = "SELECT product_id, product_name, description, conditions, seller_id, price FROM Products WHERE product_id = $id";
$statement = $connection->prepare($productRequest);

$statement->execute();
$product = $statement->fetch();

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

        // Check if item is already in cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = [
                'id' => $product_id,
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

$seller = "";
if($product['conditions'] == 'used' && isset($product['seller_id'])) {
    $sellerRequest = "SELECT username FROM Users where user_id = :id"; 

    $statement = $connection->prepare($sellerRequest);
    $statement->bindParam(":id", $product['seller_id']);
    $statement->execute();
    $seller = $statement->fetch()['username'];
}

$reviewRequest = "SELECT r.user_id, r.rating, r.comment, r.created_at, u.username FROM Reviews r LEFT JOIN Users u ON r.user_id = u.user_id WHERE product_id = '$id'";

$statement = $connection->prepare($reviewRequest);

$statement->execute();
$reviews = $statement->fetchAll();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review-text'])) {
    $reviewText = $_POST['review-text'];
    $rating = $_POST['rating'];
    $userId = $_SESSION['user_id'] ?? null;
    $productId = $id;

    if ($userId && !empty($reviewText)) {
        $safeReview = htmlspecialchars($reviewText, ENT_QUOTES, 'UTF-8');
        $stmt = $connection->prepare("INSERT INTO Reviews (product_id, user_id, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())");

        if ($stmt->execute([$productId, $userId, $rating, $safeReview])) {
            echo "<script>window.location.href = 'ProductPage.php?id=$id&review=success';</script>";
            exit;
        } else {
            echo "<p style='color: red;'>Error submitting review.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <script src="js/productPage.js"></script>

    <?php include 'Header.php'; ?>
    <link rel="stylesheet" href="css/product.css" type="text/css">
    <link rel="stylesheet" href="css/Review.css" type="text/css">
    <script>
        const isLoggedIn = <?php echo (isset($_SESSION['user']) && $_SESSION['user'] != null) ? 'true' : 'false'; ?>;
        const product_id = <?= json_encode($id) ?>;
    </script>
    <script src="js/Review.js"></script>

    <section class="products-section">
        <?php if ($product): ?>
            <div class="product">
                <!-- Left: Product Image -->
                <div class="product-image">
                    <img src="util/display_image.php?product_id=<?= $product['product_id']; ?>">
                </div>

                
                <!-- Middle: Description -->
                <div class="product-description">
                    <h1 class="product-title"><?= htmlspecialchars($product['product_name']); ?></h1>
                    <?php if ($seller != ""): ?>
                        <p><strong>sold by:</strong> <?= htmlspecialchars($seller); ?></p>
                    <?php endif; ?>
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


    <!-- The below code was created with reference from: https://www.webslesson.info/2021/05/how-to-create-review-rating-page-in-php-with-ajax.html -->
    <!-- as stated in the readme file, the ajax method was not used-->
    <!-- Reviews Section -->
    <section class="review-section">
        <h3>Game Reviews</h3>
        <?php if (isset($_GET['review']) && $_GET['review'] === 'success'): ?>
            <p style="color: green;">Review submitted successfully!</p>
        <?php endif; ?>
        <div class="reviews-container">
            <?php 
            if (empty($reviews)) {
                echo "<p>No one has reviewed this item yet.</p>";
              }
            else{
            foreach ($reviews as $review): ?>
                <div class="review">
                <p><strong>User: </strong><?= $review['username'];?><br>
                <strong>Review Date: </strong><?= $review['created_at'];?><br>
                <!-- Star Rating Display -->
                <?php for ($i = 1; $i <= 5; $i++):?>
                    <span class="fa fa-star <?= $i <= $review['rating'] ? 'checked' : '';?>"></span>
                <?php endfor;?>
                <p><?= $review['comment'];?></p>
                </div>
            <?php endforeach; 
            }?>
        </div>
    </section>

    <!-- Submit Review Section -->
    <section class="review-section">
        <h3>Submit Your Review</h3>
        <!-- Star Rating Input -->
        <div class="rating">
            <!-- Stars to click for rating -->
             <span class="fa fa-star star" onclick="selectRating(1)"></span>
            <span class="fa fa-star star" onclick="selectRating(2)"></span>
            <span class="fa fa-star star" onclick="selectRating(3)"></span>
            <span class="fa fa-star star" onclick="selectRating(4)"></span>
            <span class="fa fa-star star" onclick="selectRating(5)"></span>
             
        </div>

        <form action="ProductPage.php?id=<?= $id; ?>" method="post" id="review-form" class="review-form">
            <input type="hidden" name="rating" id="rating" value="0">
            <textarea name="review-text" required id="review-text" placeholder="Write your review here..."></textarea><br>
            <input type="submit" name="review" value="Submit Review">
        </form>
    </section>

    <footer>
        <p>&copy; 2025 Game & Stop</p>
        <a class="social-media-link" href="#"><i class="fa fa-facebook"></i></a>
        <a class="social-media-link" href="#"><i class="fa fa-twitter"></i></a>
    </footer>

</html>
