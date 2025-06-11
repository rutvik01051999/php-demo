<?php
// include '/var/www/html/php-project/config/db.php';
include __DIR__ . '../../config/db.php';

function getStates() {
    global $pdo;

    try {
        $stmt = $pdo->query("SELECT id, name FROM states ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching states: " . $e->getMessage();
        return [];
    }
}

?>
