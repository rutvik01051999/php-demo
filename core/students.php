<?php
require_once '/var/www/html/php-project/config/db.php';

function getList()
{
    global $pdo;
    if ($pdo) {
        $sql = "SELECT * FROM users";
    
        // Execute the query
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // return $stmt->fetch();
    } else {
        echo "PDO connection is not established.";
    }

}
