<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$baseURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/php-project/views/admin';
include '../../core/functions.php';
session_start();
redirect_if_not_logged_in();
$cardDetails = getCardDetails();
// print_r($cardDetails[0]);
// exit();
include '../../includes/header.php';


?>
<div class="content-wrapper container">

    <div class="container mt-4">
        <div class="row">
            <?php
            // Check if $cardDetails is not empty
            if ($cardDetails) {
               
                foreach ($cardDetails as $card) {
                    // Output each card dynamically
                    echo '<div class="col-md-4">';
                    echo '    <div class="card">';
                    echo '        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Image">';
                    echo '        <div class="card-body">';
                    echo '            <h5 class="card-title">' . $card['student_count'] . '</h5>';  // Assuming 'name' field
                    echo '            <p class="card-text">' . $card['student_count'] . '</p>';  // Assuming 'class_name' field
                    echo '            <a href="#" class="btn btn-primary">Read More</a>';
                    echo '        </div>';
                    echo '    </div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No card details available.</p>';
            }
            ?>

        </div>
    </div>

</div>

<?php include '../../includes/footer.php'; ?>