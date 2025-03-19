<?php
include "Connection.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET["image_id"])) {
    $image_id = intval($_GET["image_id"]);

    $stmt = $conn->prepare("SELECT image_data FROM Images WHERE image_id = ?");
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($imageData);
        $stmt->fetch();

        echo $imageData;
    } else {
        echo "Image not found.";
    }
}

$conn->close();
?>