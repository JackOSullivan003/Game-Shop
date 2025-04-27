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

// Check if the logout action is triggered
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
  session_start();
  $cart = $_SESSION['cart'] ?? []; // Save cart before destroying session
  session_destroy();
  session_start();
  $_SESSION['cart'] = $cart; // Restore cart after logout
  header("Location: home.php");
  exit();
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
<?php include'Header.php';?>
<link rel="stylesheet" href="css/style.css" type="text/css">
<body>
  <h1>User Account Details</h1>
<!--basic user management, update username, logout option -->

<a href="">Update User</a>

<!--logout user through php logout() and load back to home.php-->
<a href="#" onclick="logoutUser()">Logout</a>

 <a href="Home.php">Home</a>

</body>
</html>
