<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    echo "<h2>Войдите в аккаунт</h2>";
    exit;
}

$user_id = $_SESSION['user_id'];

/* получаем товары с группировкой */
$stmt = $pdo->prepare("
    SELECT 
        MIN(oi.id) as id,
        p.name,
        p.price,
        p.image,
        SUM(oi.quantity) as quantity
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    JOIN orders o ON oi.order_id = o.id
    WHERE o.user_id = ?
    AND o.status = 'new'
    GROUP BY oi.product_id
");

$stmt->execute([$user_id]);
$items = $stmt->fetchAll();
?>

<section class="cart container">

<h1 class="cart-title">Корзина</h1>

<div class="cart-items">

<?php if (!$items): ?>
    <h3>Корзина пуста</h3>
<?php else: ?>

<?php foreach ($items as $item): ?>

<div class="cart-item">

    <div class="cart-img">
        <img src="<?= htmlspecialchars($item['image']) ?>">
    </div>

    <div class="cart-info">
        <h3><?= htmlspecialchars($item['name']) ?></h3>
        <p><?= $item['price'] ?> ₽</p>
    </div>

    <div class="cart-qty">
        <?= $item['quantity'] ?>
    </div>

    <div class="cart-total">
        <?= $item['price'] * $item['quantity'] ?> ₽
    </div>

    <!-- 🔥 КНОПКА УДАЛЕНИЯ -->
    <button 
        class="cart-remove"
        data-id="<?= $item['id'] ?>">
        ✖
    </button>

</div>

<?php endforeach; ?>

<?php endif; ?>

</div>

</section>