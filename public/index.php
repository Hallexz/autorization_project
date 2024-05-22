<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'AuthController.php';

$db = new Database();
$user = new User($db);
$auth = new AuthController($user);

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            $message = $auth->register($name, $phone, $email, $password, $confirm_password);
            echo $message;
        } else {
            include 'View/register.php';
        }
        break;
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'];
            $password = $_POST['password'];

            $message = $auth->login($login, $password);
            echo $message;
        } else {
            include 'View/login.php';
        }
        break;
    case 'logout':
        $message = $auth->logout();
        echo $message;
        break;
    case 'profile':
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }
        include 'View/profile.php';
        break;
    default:
        echo "Добро пожаловать на главную страницу!";
        break;
}
?>