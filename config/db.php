<?php
// Database configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'phpmyadmin');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'php_project');

// Create a database connection
function getDbConnection() {
    try {
        $conn = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
