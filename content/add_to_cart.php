<?php
session_start();
require_once "../config/db.php";

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? null;
$product_id = $_POST['product_id'] ?? null;

if (!$user_id || !$product_id) {
    echo json_encode(["success"=>false]);
    exit;
}

/* 1. берем заказ */
$stmt = $pdo->prepare("
    SELECT id FROM orders 
    WHERE user_id = ? 
    ORDER BY id DESC 
    LIMIT 1
");
$stmt->execute([$user_id]);
$order = $stmt->fetch();

if (!$order) {
    $pdo->prepare("INSERT INTO orders (user_id,status) VALUES (?, 'new')")
        ->execute([$user_id]);

    $order_id = $pdo->lastInsertId();
} else {
    $order_id = $order['id'];
}

/* 2. ВАЖНО: проверяем товар */
$stmt = $pdo->prepare("
    SELECT id, quantity 
    FROM order_items 
    WHERE order_id = ? AND product_id = ?
");
$stmt->execute([$order_id, $product_id]);
$item = $stmt->fetch();

if ($item) {

    $pdo->prepare("
        UPDATE order_items 
        SET quantity = quantity + 1 
        WHERE id = ?
    ")->execute([$item['id']]);

} else {

    $pdo->prepare("
        INSERT INTO order_items (order_id, product_id, quantity)
        VALUES (?, ?, 1)
    ")->execute([$order_id, $product_id]);
}

echo json_encode([
    "success" => true,
    "message" => "Товар добавлен в корзину"
]);