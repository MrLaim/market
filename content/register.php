<?php
session_start();
header('Content-Type: application/json');

require __DIR__ . "/../config/db.php";

$login = trim($_POST['login'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password2 = $_POST['password2'] ?? '';

if (!$login || !$email || !$password) {
    echo json_encode(["success"=>false,"message"=>"Заполните все поля"]);
    exit;
}

if ($password !== $password2) {
    echo json_encode(["success"=>false,"message"=>"Пароли не совпадают"]);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE username=? OR email=?");
$stmt->execute([$login, $email]);

if ($stmt->fetch()) {
    echo json_encode(["success"=>false,"message"=>"Пользователь уже существует"]);
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, role)
                       VALUES (?, ?, ?, 'client')");

$stmt->execute([$login, $email, $hash]);

echo json_encode(["success"=>true,"message"=>"Регистрация успешна"]);