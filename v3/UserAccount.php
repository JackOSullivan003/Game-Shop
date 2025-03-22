<?php 
require_once 'classes/user.php';
session_start(); 

$user = $_SESSION['user'];

//display information about the user

echo "Name: " . $user->getUsername() . "<br>";
echo "Email: " . $user->getEmail() . "<br>";
echo "Full Name: " . $user->getFullName() . "<br>";
echo "address: " . $user->getAddress() . "<br>";
echo "Phone: " . $user->getPhoneNo() . "<br>";


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="description" content="" />
</head>
<body>
  <h1>User Account Details</h1>
<!--basic user management, update username, logout option -->

<a href="update_user.php">Update User</a>
<a href="logout.php">Logout</a>
 <!-- add more functionalities as needed -->
 <a href="Home.php">Home</a>
 <!-- end of user management -->
</body>
</html>
