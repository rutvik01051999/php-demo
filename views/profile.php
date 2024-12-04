<?php
include '../includes/header.php';
include '../core/functions.php';

session_start();
redirect_if_not_logged_in();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<div class="container mt-5">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
    <form method="POST"><button class="btn btn-danger">Logout</button></form>
</div>
<?php include '../includes/footer.php'; ?>
