<?php

$host = "localhost";
$dbname = "stroymarket";
$charset = "utf8mb4";
$user = "root";
$pass = "Liam_1526";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=$charset",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("DB error: " . $e->getMessage());
}