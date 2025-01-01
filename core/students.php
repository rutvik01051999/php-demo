<?php
require_once '/var/www/html/php-project/config/db.php';

// Pagination settings
$limit = 1; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get the current page
$start_from = ($page - 1) * $limit; // Starting record for the current page

// SQL query to fetch users with pagination
$stmt =  $pdo->prepare("SELECT * FROM users LIMIT :start_from, :limit");
$stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of records for pagination
$total_stmt =  $pdo->query("SELECT COUNT(id) AS total FROM users");
$total_rows = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Calculate total pages
$total_pages = ceil($total_rows / $limit);

// Return data as JSON
echo json_encode([
    'users' => $users,
    'total_pages' => $total_pages
]);


// function getList()
// {
//     global $pdo;
//     if ($pdo) {
//         $sql = "SELECT * FROM users";
    
//         // Execute the query
//         $stmt = $pdo->query($sql);
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//         // return $stmt->fetch();
//     } else {
//         echo "PDO connection is not established.";
//     }

// }
