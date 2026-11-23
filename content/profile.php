<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Личный кабинет</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Привет, <?php echo $_SESSION['username']; ?> 👋</h1>

<a href="logout.php">Выйти</a>

</body>
</html>