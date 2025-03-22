<?php

include 'Connection.php'; 

include '../classes/User.php';
$conn = Connection::getConnection();


// check if user already exists by using post variables in sql query 
$userName = $_POST['username']; 
$email = $_POST['email'];

$userResult = "SELECT * FROM users WHERE username = '$userName' AND email = '$email'";

$userResult = mysqli_query($conn, $userResult);

// Check if result contains any row (i.e., user exists)

if (mysqli_num_rows($userResult) > 0) {

    echo "User already exists. Please log in instead of registering.";

    //delay 3 seconds before redirecting to home page
    header('refresh:3; url=../home.php');

} else {

    // If user doesn't exist, insert user into database

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $fullName = $_POST['fullName'];
    //reconnect address information from form submission
    $address = $_POST['address1'] . ' ' . $_POST['address2'] . ' ' . $_POST['address3'] . ' ' . $_POST['address4'] . ' ' . $_POST['address5'];
    $phoneNo = $_POST['phoneNo'];
    $isAdmin = $_POST['isAdmin'];
    //prepare values for inserting into database
    //mysqli_real_escape_string is used to prevent SQL injection attacks and make sure the string is properly inserted

    $username = mysqli_real_escape_string($conn, $userName);
    $email = mysqli_real_escape_string($conn, $email);
    $fullName = mysqli_real_escape_string($conn, $fullName);
    $address = mysqli_real_escape_string($conn, $address);
    $phoneNo = mysqli_real_escape_string($conn, $phoneNo);
    $isAdmin = mysqli_real_escape_string($conn, $isAdmin);
    
    $sql = "INSERT INTO Users (username, email, password_hash, full_name, address, phone_number) VALUES ('$username', '$email', '$password', '$fullName', '$address', '$phoneNo')";


    if (mysqli_query($conn, $sql)) {

        echo "User registered successfully.";
        //login user
        //create user object
        $user = new User($username, $email, $password, $fullName, $address, $phoneNo, $isAdmin);
        //save user object in session
        $_SESSION['user'] = $user;

        //redirect to home page
        header('Location: ../home.php');

    } else {

        echo "Error: ". $sql. "<br>". mysqli_error($conn);

    }

}




?>
