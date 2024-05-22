<?php
class Database {
    private $host;
    private $db;
    private $username;
    private $password;
    private $conn;

    public function __construct($host = "localhost", $db = "test_db", $username = "username", $password = "password") {
        $this->host = $host;
        $this->db = $db;
        $this->username = $username;
        $this->password = $password;

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30) NOT NULL,
            phone VARCHAR(30) NOT NULL,
            email VARCHAR(50),
            password VARCHAR(50)
        )";

        try {
            $this->conn->exec($sql);
            echo "Таблица успешно создана";
        } catch (PDOException $e) {
            echo "Ошибка при создании таблицы: " . $e->getMessage();
        }
    }

    public function getUserByEmailOrPhone($email, $phone) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email OR phone = :phone");
        $stmt->execute(['email' => $email, 'phone' => $phone]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertUser($name, $phone, $email, $password) {
        $stmt = $this->conn->prepare("INSERT INTO users (name, phone, email, password) VALUES (:name, :phone, :email, :password)");
        $stmt->execute(['name' => $name, 'phone' => $phone, 'email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);

        return $stmt->rowCount() > 0;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}

$db = new Database();
$db->createTable();
print_r($db->getAllRows('users'));
$db->closeConnection();
?>
