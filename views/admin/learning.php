<?php
class Database {
    public function connect() {
        return "Database connected!";
    }
}

class UserService {
    private $db;

    public function __construct() {
        $this->db = new Database(); // BAD: Tight Coupling
    }

    public function getUser() {
        return $this->db->connect();
    }
}

// Usage
$userService = new UserService();
echo $userService->getUser();



?>