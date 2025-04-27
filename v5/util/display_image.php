<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
include "Connection.php";

try {
    if (isset($_GET["image_id"])) {
        $image_id = $_GET["image_id"];
        $stmt = $connection->prepare("SELECT image_data FROM Images WHERE image_id = :image_id");
        $stmt->execute([':image_id' => $image_id]);

        $row = $stmt->fetch();

        if ($row) {
            header("Content-Type: image/jpeg");
            echo $row['image_data'];
        } else {
            http_response_code(404);
            echo "Image not found.";
        }
    }
    else if(isset($_GET["product_id"])){
        $product_id = $_GET["product_id"];
        $stmt = $connection->prepare("SELECT image_data FROM Images WHERE product_id = :product_id");
        $stmt->execute([':product_id' => $product_id]);
        
        $row = $stmt->fetch();

        if ($row) {
            header("Content-Type: image/jpeg");
            echo $row['image_data'];
        } else {
            http_response_code(404);
            echo "Image not found.";
        }

    }
} catch (PDOException $e) {
    http_response_code(500);
    echo "Database error: " . $e->getMessage();
}

?>