<?php
include __DIR__ . '/../../core/config/db.php';
if (isset($_POST['state_id'])) {
    $stateId = $_POST['state_id'];

    $stmt = $pdo->prepare("SELECT id, name FROM cities WHERE state_id = ?");
    $stmt->execute([$stateId]);
    $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<option value="">Select City</option>';
    foreach ($cities as $city) {
        echo '<option value="' . $city['id'] . '">' . htmlspecialchars($city['name']) . '</option>';
    }
}
?>