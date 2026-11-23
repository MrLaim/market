<?php
session_start();
require_once "../config/db.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success"=>false]);
    exit;
}

$item_id = $_POST['item_id'] ?? null;

if (!$item_id) {
    echo json_encode(["success"=>false]);
    exit;
}

/* удаляем */
$pdo->prepare("
    DELETE FROM order_items WHERE id = ?
")->execute([$item_id]);

echo json_encode([
    "success" => true,
    "message" => "Удалено"
]);