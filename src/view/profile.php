<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require 'config/Database.php';

$db = new Database();
$collection = $db->getCollection('users');

$user = $collection->findOne(['_id' => $_SESSION['user_id']]);

echo "Привет, {$user['name']}!";
?>