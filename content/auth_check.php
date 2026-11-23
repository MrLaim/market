<?php

session_start();

header('Content-Type: application/json; charset=utf-8');

error_reporting(0);
ini_set('display_errors', 0);

echo json_encode([
    "logged" => isset($_SESSION['user_id']),
    "user_id" => $_SESSION['user_id'] ?? null
]);