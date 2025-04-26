<?php
/**
* Configuration for database connection
*/
    $servername = "localhost";
    $username = "shop";
    $password = "shop";
    $dbname = "games_shop";
    $dsn = "mysql:host=$servername; dbname=$dbname"; 
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
?>