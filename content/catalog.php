<?php
require_once "../config/db.php";

/* получаем товары */
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<section class="container">

<h2>Каталог</h2>

<div class="products">

<?php foreach ($products as $product): ?>

<div class="card product">

    <img src="<?= htmlspecialchars($product['image']) ?>">

    <h3><?= htmlspecialchars($product['name']) ?></h3>

    <p><?= $product['price'] ?> ₽</p>

    <button 
        class="btn add-to-cart"
        data-id="<?= $product['id'] ?>">
        В корзину
    </button>

</div>

<?php endforeach; ?>

</div>

</section>