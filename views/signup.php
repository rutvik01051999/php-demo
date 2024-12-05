<?php
session_start();
include '../core/auth.php';
include '../core/functions.php';
redirect_if_logged_in();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (register($name, $email, $password)) {
        header("Location: login.php?signup=success");
        exit;
    } else {
        echo "<p class='text-danger'>Registration failed. Email might be taken.</p>";
    }
}
?>

<?php include '../includes/footer.php'; ?>
