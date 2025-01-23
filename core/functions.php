<?php
include(__DIR__ . '/../config/db.php');

function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

function redirect_if_logged_in($location = 'profile.php')
{
    if (is_logged_in()) {
        header("Location: $location");
        exit;
    } else {
        echo "You are not logged in";
    }
}

function redirect_if_not_logged_in($location = 'login.php')
{
    if (!is_logged_in()) {
        header("Location: $location");
        exit;
    } else {
        echo "You are already logged in";
    }
}

function getCardDetails()
{
    global $pdo;
    $role = isset($_GET['role']) ? $_GET['role'] : 'student';

    if ($role == 'student') {
        $sql = "SELECT 
    COUNT(students.id) AS student_count
FROM 
    school_classes
LEFT JOIN 
    students ON school_classes.id = students.class_id;";
    } else if ($role == 'teacher') {
    } else {
    }

    // Prepare and execute the query
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Fetch the results
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $students;
}
