<?php
require_once "../config/db.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Товар не найден";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);

$product = $stmt->fetch();

if (!$product) {
    echo "Товар не найден";
    exit;
}
?>

<div class="product-page">

    <div class="product-top">

        <div class="product-info card-specs">

            <h1><?= htmlspecialchars($product['name']) ?></h1>

            <p><b>Размер:</b> <?= htmlspecialchars($product['size'] ?? '') ?></p>
            <p><b>Формат:</b> <?= htmlspecialchars($product['format'] ?? '') ?></p>
            <p><b>Тип:</b> <?= htmlspecialchars($product['type'] ?? '') ?></p>
            <p><b>Марка прочности:</b> <?= htmlspecialchars($product['strength'] ?? '') ?></p>
            <p><b>Производитель:</b> <?= htmlspecialchars($product['manufacturer'] ?? '') ?></p>

        </div>

        <div class="product-image">
            <img src="<?= htmlspecialchars($product['image'] ?? '') ?>">
        </div>

    </div>

    <div class="product-description card-desc">

        <h2>Описание</h2>

        <p><?= nl2br(htmlspecialchars($product['full_description'] ?? '')) ?></p>

    </div>
    
    <button class="btn add-to-cart" data-id="<?= $product['id'] ?>">
    в корзину
</button>

</div>