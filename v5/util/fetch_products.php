<?php
require_once "connection.php";

if (isset($_GET['category_id']) && $_GET['arg'] === 'name') {
    $stmt = $connection->prepare("SELECT product_id, product_name FROM Products WHERE category_id = :id");
    $stmt->execute([':id' => $_GET['category_id']]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
?>