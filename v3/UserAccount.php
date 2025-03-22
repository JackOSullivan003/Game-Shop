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

//function for logout of user
function logout() {
  session_destroy();  // Destroy session
  header("Location: Home.php"); // Redirect to home
  exit();
}

// Check if the logout action is triggered
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
  logout();
}
?>

<script>
function logoutUser() {
    fetch("?action=logout")
        .then(response => window.location.href = "Home.php"); // Redirect after logout
}
</script>

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

<a href="logout()">Update User</a>
<!--logout user through php logout() and load back to home.php-->

<a href="#" onclick="logoutUser()">Logout</a>
 <!-- add more functionalities as needed -->
 <a href="Home.php">Home</a>
 <!-- end of user management -->
</body>
</html>
