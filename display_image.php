<?php
$servername = "localhost";
$username = "shop";
$password = "shop";
$dbname = "games_shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET["image_id"])) {
    $image_id = intval($_GET["image_id"]);

    $imageRequest = "SELECT image_data FROM Images WHERE $image_id = image_id";


    $imageResult = mysqli_query($conn, $imageRequest);

    if ($imageResult->num_rows > 0) {
        $imageResult.bind_result($imageData, $imageType);
        
        header("Content-Type: " . $imageType);
        echo $imageData;
    } else {
        echo "Image not found.";
    }

    $stmt->close();
}

$conn->close();
?>