<?php
header('Content-Type: application/json');
require_once '/var/www/html/php-project/config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve input data
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $inputAddress_current = trim($_POST['inputAddress_current']);
    $inputAddress2_current = trim($_POST['inputAddress2_current']);
    $inputCity_current = trim($_POST['inputCity_current']);
    $inputState_current = trim($_POST['inputState_current']);
    $inputZip_current = trim($_POST['inputZip_current']);
    $inputAddress_permanent = trim($_POST['inputAddress_permanent']);
    $inputAddress2_permanent = trim($_POST['inputAddress2_permanent']);
    $inputCity_permanent = trim($_POST['inputCity_permanent']);
    $inputState_permanent = trim($_POST['inputState_permanent']);
    $inputZip_permanent = trim($_POST['inputZip_permanent']);
    $checkbox = trim($_POST['same_address']);


    echo $checkbox;
    exit;


    // Validation errors array
    $errors = [];

    // Server-side validation
    if (empty($first_name)) {
        $errors['first_name'] = "First name is required.";
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $first_name)) {
        $errors['first_name'] = "First name should only contain letters and spaces.";
    }

    if (empty($last_name)) {
        $errors['last_name'] = "Last name is required.";
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $last_name)) {
        $errors['last_name'] = "Last name should only contain letters and spaces.";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if (empty($mobile)) {
        $errors['mobile'] = "Mobile number is required.";
    } elseif (!preg_match("/^\d{10}$/", $mobile)) {
        $errors['mobile'] = "Mobile number must be 10 digits.";
    }

    if (empty($inputAddress_current)) {
        $errors['inputAddress_current'] = "Current address is required.";
    }

    if (empty($inputCity_current)) {
        $errors['inputCity_current'] = "Current city is required.";
    }

    if (empty($inputState_current)) {
        $errors['inputState_current'] = "Current state is required.";
    }

    if (empty($inputZip_current)) {
        $errors['inputZip_current'] = "Current ZIP code is required.";
    } elseif (!is_numeric($inputZip_current)) {
        $errors['inputZip_current'] = "ZIP code must be numeric.";
    }

    if (empty($inputAddress_permanent)) {
        $errors['inputAddress_permanent'] = "Permanent address is required.";
    }

    if (empty($inputCity_permanent)) {
        $errors['inputCity_permanent'] = "Permanent city is required.";
    }

    if (empty($inputState_permanent)) {
        $errors['inputState_permanent'] = "Permanent state is required.";
    }

    if (empty($inputZip_permanent)) {
        $errors['inputZip_permanent'] = "Permanent ZIP code is required.";
    } elseif (!is_numeric($inputZip_permanent)) {
        $errors['inputZip_permanent'] = "ZIP code must be numeric.";
    }

    // Check for validation errors
    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    try {
        // Database connection
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert query
        $stmt = $pdo->prepare("
            INSERT INTO students 
            (first_name, last_name, email, mobile, inputAddress_current, inputAddress2_current, inputCity_current, inputState_current, inputZip_current, inputAddress_permanent, inputAddress2_permanent, inputCity_permanent, inputState_permanent, inputZip_permanent)
            VALUES 
            (:first_name, :last_name, :email, :mobile, :inputAddress_current, :inputAddress2_current, :inputCity_current, :inputState_current, :inputZip_current, :inputAddress_permanent, :inputAddress2_permanent, :inputCity_permanent, :inputState_permanent, :inputZip_permanent)
        ");

        // Bind parameters
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
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
