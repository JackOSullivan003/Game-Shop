<?php
include 'connection.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT category_id, category_name, category_type FROM Categories";
$result = $conn->query($sql);

$categories = [];

while ($row = $result->fetch_assoc()) {
    $categories[$row['category_type']][] = $row;
}

$conn->close();

echo json_encode($categories);
?>
