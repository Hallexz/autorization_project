<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require 'config/Database.php';

$db = new Database();
$user = $db->getUserByEmailOrPhone($_SESSION['user_id']);

echo "Привет, {$user['name']}!";
?>

<?php
require 'config/Database.php';

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password != $confirm_password) {
    die('Пароли не совпадают');
}

$db = new Database();
$user = $db->getUserByEmailOrPhone($email, $phone);
if ($user) {
    die('Пользователь с таким email или телефоном уже существует');
}

$result = $db->insertUser($name, $phone, $email, $password);
if ($result) {
    header('Location: login.php');
} else {
    die('Ошибка при создании учетной записи');
}