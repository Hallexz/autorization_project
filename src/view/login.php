<?php
require 'config/Database.php';

$login = $_POST['login'];
$password = $_POST['password'];

$db = new Database();
$collection = $db->getCollection('users');

$user = $collection->findOne(['$or' => [['email' => $login], ['phone' => $login]]]);
if (!$user || !password_verify($password, $user['password'])) {
    die('Неверный логин или пароль');
}

session_start();
$_SESSION['user_id'] = $user['_id'];

header('Location: profile.php');
?>

