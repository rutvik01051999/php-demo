<?php
include __DIR__ . '/../../config/db.php';

$id = $_POST['id'];
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id LIMIT 1");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$student = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'data' => $student,
]);