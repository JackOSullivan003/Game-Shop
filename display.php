<?php
$host = 'localhost';
$dbname = 'games_shop';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the image ID from the URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Prepare SQL statement
$sql = "SELECT product_image FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

// Bind the result
$stmt->bind_result($product_image);

if ($stmt->fetch()) {
    // Set appropriate content type (assuming JPEG, modify as needed)
    header("Content-Type: image/jpeg"); // Change if using PNG, GIF, etc.
    header("Content-Length: " . mb_strlen($product_image, '8bit'));
    
    echo $product_image; // Output the binary image data
} else {
    echo "Image not found.";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>

