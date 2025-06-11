<?php
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function redirect_if_logged_in($location = 'admin/dashboard.php') {
    if (is_logged_in()) {
        header("Location: $location");
        exit;
    }else{
        // echo "You are not logged in";
    }
}

function redirect_if_not_logged_in($location = 'login.php') {
    if (!is_logged_in()) {
        header("Location: $location");
        exit;
    }else{
        //echo "You are already logged in";
    }
}
?>
