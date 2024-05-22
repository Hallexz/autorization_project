<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserByEmailOrPhone($email, $phone) {
        return $this->db->getUserByEmailOrPhone($email, $phone);
    }

    public function insertUser($name, $phone, $email, $password) {
        return $this->db->insertUser($name, $phone, $email, $password);
    }

    public function updateUser($id, $name, $phone, $email, $password) {
        return $this->db->updateUser($id, $name, $phone, $email, $password);
    }
}
?>