<?php

ini_set('session.cookie_samesite', 'Lax');

session_set_cookie_params([
    'path' => '/',
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

header('Content-Type: application/json');

require __DIR__ . "/../config/db.php";

try {

    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$login || !$password) {
        throw new Exception("Заполните поля");
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=? OR email=?");
    $stmt->execute([$login, $login]);
    $user = $stmt->fetch();

    if (!$user) {
        throw new Exception("Пользователь не найден");
    }

    if (!password_verify($password, $user['password_hash'])) {
        throw new Exception("Неверный пароль");
    }

    $_SESSION['user_id'] = $user['id'];

    echo json_encode([
        "success" => true,
        "message" => "Успешный вход"
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}