<?php
include 'Connection.php';

$conn = Connection::getConnection();

$sql = "SELECT category_id, category_name, category_type FROM Categories";
$result = $conn->query($sql);

$categories = [];

while ($row = $result->fetch_assoc()) {
    $categories[$row['category_type']][] = $row;
}

$conn->close();

echo json_encode($categories);
?>
