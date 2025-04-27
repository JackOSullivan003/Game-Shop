<?php
require_once "../classes/User.php"; // Ensure the correct path to your User class

require_once "../util/Connection.php"; 

// Function to check test results
function assertEquals($expected, $actual, $message) {
    if ($expected === $actual) {
        //echo message and move to new line
        echo nl2br("[PASS] $message\n");
    } else {
        //echo message and move to new line
        echo nl2br("[FAIL] $message - Expected: '$expected', Got: '$actual'\n");
    }
}

//create new user and test getters and setters 
$user = new User(null, "testuser", "password123", "test@example.com", "Test User", "123 Test St", "1234567890");

$user->login();

//test getting username 
assertEquals("testuser", $user->getUsername(), "Test getting username");

//test setting username
$user->setUsername("newuser");
assertEquals("newuser", $user->getUsername(), "Test setting username");

//test getting password
assertEquals("password123", $user->getPassword(), "Test getting password");

//test setting password
$user->setPassword("newpassword");
assertEquals("newpassword", $user->getPassword(), "Test setting password");

//test getting email
assertEquals("test@example.com", $user->getEmail(), "Test getting email");

//test setting email
$user->setEmail("newemail@example.com");
assertEquals("newemail@example.com", $user->getEmail(), "Test setting email");

//test getting fullName
assertEquals("Test User", $user->getFullName(), "Test getting fullName");

//test setting fullName
$user->setFullName("New Full Name");
assertEquals("New Full Name", $user->getFullName(), "Test setting fullName");

//test getting address
assertEquals("123 Test St", $user->getAddress(), "Test getting address");

//test setting address
$user->setAddress("123 New St");
assertEquals("123 New St", $user->getAddress(), "Test setting address");

//test getting phoneNo
assertEquals("1234567890", $user->getPhoneNo(), "Test getting phoneNo");

//test setting phoneNo
$user->setPhoneNo("9876543210");
assertEquals("9876543210", $user->getPhoneNo(), "Test setting phoneNo");

//test getting id 
$id = $user->getId();
echo nl2br("id = $id\n");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Unit Test</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="description" content="" />
</head>
<body>
<!--Home link -->

<a href=".">Back</a>

</body>
</html>