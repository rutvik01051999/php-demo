<?php
require_once '../models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function listUsers() {
        return $this->userModel->getAllUsers();
    }

    public function createUser($name, $email) {
        return $this->userModel->createUser($name, $email);
    }

    public function getUser($id) {
        return $this->userModel->getUserById($id);
    }

    public function updateUser($id, $name, $email) {
        return $this->userModel->updateUser($id, $name, $email);
    }

    public function deleteUser($id) {
        return $this->userModel->deleteUser($id);
    }
}
?>
