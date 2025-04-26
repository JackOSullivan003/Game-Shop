<?php
include 'Connection.php';

$sql = "SELECT category_id, category_name, category_type FROM Categories";

$statement = $connection->prepare($sql);

if($statement->execute()){  
    $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

    $grouped = ["Games" => [], "Merch" => []];

    foreach ($categories as $row) {
        if ($row['category_type'] === 'Games') {
            $grouped['Games'][] = $row;
        } elseif ($row['category_type'] === 'Merch') {
            $grouped['Merch'][] = $row;
        }
    }
    $categories = json_encode($grouped); 
    echo $categories;
}
else {
    echo "error getting categories: " + $statement -> errorInfo();
}
?>
