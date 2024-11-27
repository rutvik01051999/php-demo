<?php
require_once '../controllers/UserController.php';

$userController = new UserController();
$users = $userController->listUsers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
</head>
<body>
    <h1>All Users</h1>
    <a href="addUser.php">Add New User</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['name'] ?></td>
            <td><?= $user['email'] ?></td>
            <td>
                <a href="editUser.php?id=<?= $user['id'] ?>">Edit</a>
                <a href="deleteUser.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
