<?php
$host = 'localhost';
$dbname = 'u791328025_school';
$username = 'u791328025_school';
$password = 'Rutvik@01051999';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
    exit;
}
?>