<?php
require_once "../config/db.php";

$q = $_GET['q'] ?? '';

if (!$q) {
    exit;
}

/* поиск по нескольким полям */
$stmt = $pdo->prepare("
    SELECT * FROM products
    WHERE name LIKE ?
    OR subtitle LIKE ?
    OR type LIKE ?
");

$search = "%" . $q . "%";

$stmt->execute([$search, $search, $search]);

$products = $stmt->fetchAll();

if (!$products) {
    echo "<p>Ничего не найдено</p>";
    exit;
}

/* вывод карточек */
foreach ($products as $product) {
    echo '
    <a href="#" class="product-link" data-id="'.$product['id'].'">
        <div class="card product">
            <img src="'.$product['image'].'">
            <h3>'.$product['name'].'</h3>
            <p>'.$product['price'].' р.</p>
        </div>
    </a>
    ';
}