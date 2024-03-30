<?php 
class dbConnection {
    private static $servername = "localhost"; // Change this if your MySQL server is running on a different host
    private static $username = "root"; 
    private static $password = ""; 
    private static $database = "tickety"; 
    private static $db = null;

    private function __construct() {
        try {
            self::$db = new PDO("mysql:host=" . self::$servername . ";dbname=" . self::$database, self::$username, self::$password);
            // Set the PDO error mode to exception
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    public static function getConnection() {
        if (self::$db == null) {
            new dbConnection();
        }
        return self::$db;
    }

}