<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>СтройМаркет</title>

    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
</head>

<body>

<header class="header">
    <div class="container nav">

        <div class="logo">
            <img src="img/logo.png">
        </div>

        <nav class="menu">
            <a href="#" data-page="home">Главная</a>
            <a href="#" data-page="catalog">Каталог</a>
            <a href="#" data-page="carth">Корзина</a>
            <a href="#" id="authBtn" onclick="authAction(event)">Вход</a>
        </nav>

    </div>
</header>

<!-- 🔥 ВОТ СЮДА ВСЁ МЕНЯЕТСЯ -->
<div id="content"></div>

<footer class="footer">©стройматериал</footer>

</body>
</html>