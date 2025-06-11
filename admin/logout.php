<?php
session_start();       // Start the session first
session_unset();       // (optional) Clear all session variables
session_destroy();     // Destroy the session data
header("Location: http://localhost/php-project/views/login.php");
exit;
