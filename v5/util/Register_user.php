<?php

include 'Connection.php'; 
include 'common.php';

include '../classes/User.php';


$email = $_POST['email'];
$emailSafe = escape($email);

$sql = "SELECT * FROM users WHERE email = '$emailSafe'";

$statement = $connection->prepare($sql);
$statement->execute();

// Check if result contains any row (i.e., user exists)
$row = $statement->fetch(PDO::FETCH_ASSOC);

if ($row) {
    
    echo "This Email already has a User. Please log in instead of registering.";
    
    //delay 3 seconds before redirecting to home page
    header('refresh:3; url=../home.php');
    exit();
    
} else {
    
    // If user doesn't exist, insert user into database
    $userName = $_POST['username'];
    $password = $_POST['password']; 
    $fullName = $_POST['fullName'];
    //reconnect address information from form submission
    $address = $_POST['address1'] . ' ' . $_POST['address2'] . ' ' . $_POST['address3'] . ' ' . $_POST['address4'] . ' ' . $_POST['address5'];
    $phoneNo = $_POST['phoneNo'];
    //prepare values for inserting into database
    //escape from common.php is used to prevent SQL injection attacks and make sure the string is properly inserted
    $usernameSafe = escape($userName); 
    $passwordSafe = escape($password);
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $fullName = escape($fullName);
    $address = escape($address);
    $phoneNo = escape($phoneNo); 


    $sql = "INSERT INTO Users (username, email, password_hash, full_name, address, phone_number, user_type) VALUES (:username, :email, :passwordHash, :fullName, :address, :phoneNo, 'user')";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':username', $usernameSafe);
    $statement->bindParam(':email', $emailSafe);
    $statement->bindParam(':passwordHash', $passwordHash);
    $statement->bindParam(':fullName', $fullName);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':phoneNo', $phoneNo);

if ($statement->execute()) {
    echo "Registration successful! logging in...";
    $stmt = $connection->prepare("SELECT * FROM Users WHERE email = :email");
    $stmt->execute(['email' => $emailSafe]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $user = new User($result['user_id'], $result['username'], $result['password_hash'], $result['email'], $result['full_name'], $result['address'], $result['phone_number']);
    $user->login();
    header("refresh:3; url=../home.php");
} else {
    echo "Error: " . implode(", ", $statement->errorInfo());
}
}

?>
