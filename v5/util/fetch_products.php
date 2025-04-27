<?php
require_once "connection.php";


if (isset($_GET['category_id'])) {
    if(!isset($_GET['arg'])){
        $stmt = $connection->prepare("SELECT p.product_id, p.product_name, p.quantity FROM Products p INNER JOIN (SELECT MIN(product_id) AS product_id FROM Products GROUP BY product_name) AS unique_products ON p.product_id = unique_products.product_id WHERE p.category_id = :id;");
        $stmt->execute([':id' => (int)$_GET['category_id']]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    else{
        $argument = $_Get['arg'];
        if($argument === 'used'){
            $stmt = $connection->prepare("SELECT product_id, product_name, quantity FROM Products WHERE category_id = :id AND conditions = 'used'");
            $stmt->execute([':id' => (int)$_GET['category_id']]);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        else if($argument === 'new'){
            $stmt = $connection->prepare("SELECT product_id, product_name, quantity FROM Products WHERE category_id = :id AND conditions = 'new'");
            $stmt->execute([':id' => (int)$_GET['category_id']]);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        
    }
    
    
    
    
    
}
?>