<?php
include '../config/db.php';

function login($email, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['is_logged_in'] = true;
        return true;
    }
    return false;
}

function register($name, $email, $password) {
    global $pdo;
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    session_start();
    $_SESSION['user_id'] = $name;
    $_SESSION['user_name'] = $email;
    $_SESSION['is_logged_in'] = true;
    return $stmt->execute([$name, $email, $hashedPassword]);
}
?>
