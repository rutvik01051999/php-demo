<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'auth_system');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get username and password from POST request
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verify the password using password_verify()
        if (password_verify($password, $user['password'])) {
            // Password is correct, store user details in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            
            // Redirect to the profile page or dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Invalid credentials.";
        }
    } else {
        echo "User not found.";
    }

    $conn->close();
}
?>

<form method="POST" action="login.php">
    <label>Username:</label><br>
    <input type="text" name="username" required><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
