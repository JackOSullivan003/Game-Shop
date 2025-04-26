<?php
include "../util/Connection.php";

$stmt = $connection->prepare("SELECT COUNT(*) FROM Images");
$stmt->execute();
$count = $stmt->fetchColumn();

echo "Image count: $count";

$stmt = $connection->prepare("SELECT image_data FROM Images WHERE image_id = :id");
$stmt->execute(['id' => 1]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
echo $result['image_data'];

?>