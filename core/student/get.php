<?php
include __DIR__ . '/../../config/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $limit;

// Input filters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchField = $_GET['searchField'] ?? '';
$sortField = $_GET['sortField'] ?? 'name';
$sortOrder = strtolower($_GET['sortOrder'] ?? 'asc');

// Validate sort field and order
$validSortFields = [
    'name' => 'students.first_name',
    'email' => 'students.email',
    'date' => 'students.created_at'
];
$sortFieldSql = $validSortFields[$sortField] ?? 'students.first_name';
$sortOrderSql = in_array($sortOrder, ['asc', 'desc']) ? strtoupper($sortOrder) : 'ASC';

$where = '';
$params = [];

// Handle filtering
if ($search !== '' && $searchField === 'name') {
    $where = "WHERE students.first_name LIKE ?";
    $params[] = '%' . $search . '%';

} elseif ($search !== '' && $searchField === 'parents_name') {
    // Step 1: Search parents table
    $parentStmt = $pdo->prepare("SELECT id FROM parents WHERE first_name LIKE ?");
    $parentStmt->execute(['%' . $search . '%']);
    $parentIds = $parentStmt->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($parentIds)) {
        // Step 2: Get student_ids from students_parents
        $inClause = implode(',', array_fill(0, count($parentIds), '?'));
        $spStmt = $pdo->prepare("SELECT student_id FROM students_parents WHERE parent_id IN ($inClause)");
        $spStmt->execute($parentIds);
        $studentIds = $spStmt->fetchAll(PDO::FETCH_COLUMN);

        if (!empty($studentIds)) {
            $inStudents = implode(',', array_fill(0, count($studentIds), '?'));
            $where = "WHERE students.id IN ($inStudents)";
            $params = array_merge($params, $studentIds);
        } else {
            echo json_encode(['users' => [], 'total_pages' => 0]);
            exit;
        }
    } else {
        echo json_encode(['users' => [], 'total_pages' => 0]);
        exit;
    }
}

// Final query
$query = "SELECT * FROM students $where ORDER BY $sortFieldSql $sortOrderSql LIMIT ?, ?";
$stmt = $pdo->prepare($query);

// Bind dynamic and pagination params
$bindIndex = 1;
foreach ($params as $param) {
    $stmt->bindValue($bindIndex++, $param);
}
$stmt->bindValue($bindIndex++, (int)$start_from, PDO::PARAM_INT);
$stmt->bindValue($bindIndex++, (int)$limit, PDO::PARAM_INT);

$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count query
$countQuery = "SELECT COUNT(*) as total FROM students $where";
$countStmt = $pdo->prepare($countQuery);

// Rebind same where params
$bindIndex = 1;
foreach ($params as $param) {
    $countStmt->bindValue($bindIndex++, $param);
}
$countStmt->execute();
$total_rows = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_rows / $limit);

// Output
echo json_encode([
    'users' => $users,
    'total_pages' => $total_pages
]);
