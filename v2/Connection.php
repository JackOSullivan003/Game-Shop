<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
class Connection {
    
    private static $servername = "localhost";
    private static $username = "shop";
    private static $password = "shop";
    private static $dbname = "games_shop";

    static $conn = null;
    public static function getConnection() {
        //create a connection only if one doesnt already exist
        if (self::$conn == null) {
            try{
                //use sqli to make a connection 
                self::$conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
            }
            catch(mysqli_sql_exception $e){
                echo "Connection failed: ". $e->getMessage();
            }
        }
        return self::$conn; //return the connection object for further use in other classes or functions.
    }


}
?>