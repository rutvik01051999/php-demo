<?php
include __DIR__ . '../../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Student deleted successfully.']);
        } else {
            echo json_encode(['success' => 'error', 'message' => 'Failed to delete student.']);
        }
    } else {
        echo json_encode(['success' => 'error', 'message' => 'Invalid ID.']);
    }
} else {
    echo json_encode(['success' => 'error', 'message' => 'Invalid request method.']);
}