<?php
header('Content-Type: application/json');
// require_once '/var/www/html/php-project/config/db.php';
include __DIR__ . '../../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? trim($_POST['id']) : null;
    $class_id = isset($_POST['class_div']) ? trim($_POST['class_div']) : null;
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);

    // Validation errors array
    $errors = [];
    $students = isset($_POST['students']) ? $_POST['students'] : [];

    if (empty($students)) {
        $errors['students'] = "At least one student is required.";
    } elseif (!is_array($students)) {
        $errors['students'] = "Invalid student data format.";
    } else {
        // Optional: Validate each student ID
        foreach ($students as $student_id) {
            if (!ctype_digit($student_id)) {
                $errors['students'] = "Invalid student ID detected.";
                break;
            }
        }
    }
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
                    class_id = :class_id,
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
    INSERT INTO parents 
    (first_name, last_name, email, mobile_primary)
    VALUES 
    (:first_name, :last_name, :email, :mobile_primary)
");
        }

        // Bind parameters
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mobile_primary', $mobile);
        $stmt->execute();
        $parent_id = $pdo->lastInsertId(); // if this insert was for parent

        if (!empty($students) && is_array($students)) {
            $stmtLink = $pdo->prepare("INSERT INTO students_parents (student_id, parent_id) VALUES (:student_id, :parent_id)");

            foreach ($students as $student_id) {
                if (ctype_digit($student_id)) {
                    $stmtLink->execute([
                        ':student_id' => $student_id,
                        ':parent_id' => $parent_id
                    ]);
                }
            }
        }


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
    exit;
}
