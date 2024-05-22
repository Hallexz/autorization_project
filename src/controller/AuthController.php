<?php
require_once 'User.php';
require_once 'Database.php';

class AuthController {
    private $user;

    public function __construct() {
        $db = new Database();
        $this->user = new User($db);
    }

    public function register($name, $phone, $email, $password, $confirm_password) {
        if ($password != $confirm_password) {
            return 'Пароли не совпадают';
        }

        $user = $this->user->getUserByEmailOrPhone($email, $phone);
        if ($user) {
            return 'Пользователь с таким email или телефоном уже существует';
        }

        $result = $this->user->insertUser($name, $phone, $email, $password);
        if ($result) {
            return 'Успешная регистрация';
        } else {
            return 'Ошибка при создании учетной записи';
        }
    }

    public function login($login, $password) {
        $user = $this->user->getUserByEmailOrPhone($login, $login);
        if (!$user || !password_verify($password, $user['password'])) {
            return 'Неверный логин или пароль';
        }

        session_start();
        $_SESSION['user_id'] = $user['id'];

        return 'Успешный вход в систему';
    }

    public function logout() {
        session_start();
        unset($_SESSION['user_id']);
        session_destroy();

        return 'Успешный выход из системы';
    }
}
?>