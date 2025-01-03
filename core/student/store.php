<?php
header('Content-Type: application/json');
// include '../config/db.php';
require_once '/var/www/html/php-project/config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $inputAddress_current = $_POST['inputAddress_current'];
    $inputAddress2_current = $_POST['inputAddress2_current'];
    $inputCity_current = $_POST['inputCity_current'];
    $inputState_current = $_POST['inputState_current'];
    $inputZip_current = $_POST['inputZip_current'];
    $inputAddress_permanent = $_POST['inputAddress_permanent'];
    $inputAddress2_permanent = $_POST['inputAddress2_permanent'];
    $inputCity_permanent = $_POST['inputCity_permanent'];
    $inputState_permanent = $_POST['inputState_permanent'];
    $inputZip_permanent = $_POST['inputZip_permanent'];

    try {
        // Database connection
        // $conn = new PDO("mysql:host=localhost;dbname=your_database_name", "your_username", "your_password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert query
        $stmt = $pdo->prepare("
            INSERT INTO students 
            (first_name, last_name, email, mobile, inputAddress_current, inputAddress2_current, inputCity_current, inputState_current, inputZip_current, inputAddress_permanent, inputAddress2_permanent, inputCity_permanent, inputState_permanent, inputZip_permanent)
            VALUES 
            (:first_name, :last_name, :email, :mobile, :inputAddress_current, :inputAddress2_current, :inputCity_current, :inputState_current, :inputZip_current, :inputAddress_permanent, :inputAddress2_permanent, :inputCity_permanent, :inputState_permanent, :inputZip_permanent)
        ");

        // Bind parameters
        $stmt->bindParam(':first_name', $email);
        $stmt->bindParam(':last_name', $email);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':inputAddress_current', $inputAddress_current);
        $stmt->bindParam(':inputAddress2_current', $inputAddress2_current);
        $stmt->bindParam(':inputCity_current', $inputCity_current);
        $stmt->bindParam(':inputState_current', $inputState_current);
        $stmt->bindParam(':inputZip_current', $inputZip_current);
        $stmt->bindParam(':inputAddress_permanent', $inputAddress_permanent);
        $stmt->bindParam(':inputAddress2_permanent', $inputAddress2_permanent);
        $stmt->bindParam(':inputCity_permanent', $inputCity_permanent);
        $stmt->bindParam(':inputState_permanent', $inputState_permanent);
        $stmt->bindParam(':inputZip_permanent', $inputZip_permanent);

        // Execute query
        $stmt->execute();


     

         // Fetch the last inserted ID
         $lastId = $pdo->lastInsertId();

         // Query the newly inserted record
         $query = $pdo->prepare("SELECT * FROM students WHERE id = :id");
         $query->bindParam(':id', $lastId, PDO::PARAM_INT);
         $query->execute();
 
         // Fetch the record as an associative array
         $newRecord = $query->fetch(PDO::FETCH_ASSOC);

         echo json_encode(['success' => true, 'data' => $newRecord]);
        } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
