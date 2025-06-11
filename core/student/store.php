<?php
header('Content-Type: application/json');
// require_once '/var/www/html/php-project/config/db.php';
include __DIR__ . '../../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // echo '<pre>';
    // print_r($_POST);  // Print the entire POST data
    // echo '</pre>';

    // Retrieve input data
    $id = isset($_POST['id']) ? trim($_POST['id']) : null;
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $inputAddress_current = trim($_POST['inputAddress_current']);
    $inputAddress2_current = trim($_POST['inputAddress2_current']);
    $inputCity_current = trim($_POST['inputCity_current']);
    $inputState_current = trim($_POST['inputState_current']);
    $inputZip_current = trim($_POST['inputZip_current']);
    $inputAddress_permanent = trim($_POST['inputAddress_permanent']) ? trim($_POST['inputAddress_permanent']) : null;
    $inputAddress2_permanent = trim($_POST['inputAddress2_permanent']) ? trim($_POST['inputAddress2_permanent']) : null;
    $inputCity_permanent = trim($_POST['inputCity_permanent']) ?  trim($_POST['inputCity_permanent']) : null;
    $inputState_permanent = trim($_POST['inputState_permanent']) ? trim($_POST['inputState_permanent']) : null;
    $inputZip_permanent = trim($_POST['inputZip_permanent']);
    $same_address = trim($_POST['same_address']);

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

    if ($same_address == 0) {

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
    }

    // Check for validation errors
    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    try {
        // Database connection
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($id) {
            // Check if the student exists
            $stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $existingStudent = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingStudent) {
                // Update existing student
                $stmt = $pdo->prepare("
                    UPDATE students SET
                    first_name = :first_name,
                    last_name = :last_name,
                    email = :email,
                    mobile = :mobile,
                    inputAddress_current = :inputAddress_current,
                    inputAddress2_current = :inputAddress2_current,
                    inputCity_current = :inputCity_current,
                    inputState_current = :inputState_current,
                    inputZip_current = :inputZip_current,
                    inputAddress_permanent = :inputAddress_permanent,
                    inputAddress2_permanent = :inputAddress2_permanent,
                    inputCity_permanent = :inputCity_permanent,
                    inputState_permanent = :inputState_permanent,
                    inputZip_permanent = :inputZip_permanent,
                    same_address = :same_address
                    WHERE id = :id
                ");

                // Bind parameters
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            } else {
                echo json_encode(['success' => false, 'message' => 'Student not found.']);
                exit;
            }
        } else {
            // Insert new student
            $stmt = $pdo->prepare("
                INSERT INTO students 
                (first_name, last_name, email, mobile, inputAddress_current, inputAddress2_current, inputCity_current, inputState_current, inputZip_current, inputAddress_permanent, inputAddress2_permanent, inputCity_permanent, inputState_permanent, inputZip_permanent,same_address)
                VALUES 
                (:first_name, :last_name, :email, :mobile, :inputAddress_current, :inputAddress2_current, :inputCity_current, :inputState_current, :inputZip_current, :inputAddress_permanent, :inputAddress2_permanent, :inputCity_permanent, :inputState_permanent, :inputZip_permanent, :same_address)
            ");
        }

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
        $stmt->bindParam(':same_address', $same_address);
        // Execute query
        $stmt->execute();

        if (!$id) {
            $id = $pdo->lastInsertId(); // Fetch new ID if inserted
        }

        // Fetch the updated/newly inserted record
        $query = $pdo->prepare("SELECT * FROM students WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $student = $query->fetch(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'data' => $student]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
