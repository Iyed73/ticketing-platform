<?php 
class dbConnection {
    private static $servername; // Change this if your MySQL server is running on a different host
    private static $username;
    private static $password;
    private static $database ;
    private static $db = null;

    private function __construct() {
        self::$database = $_ENV['DATABASE_NAME'];
        self::$servername = $_ENV["DB_SERVERNAME"];
        self::$username = $_ENV['DB_USERNAME'];
        self::$password = $_ENV['DB_PASSWORD'];
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
            new self(); // Corrected line: create a new instance of self
        }
        return self::$db;
    }

}

