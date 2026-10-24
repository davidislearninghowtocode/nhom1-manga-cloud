<?php
require_once 'config.php';
include 'includes/header.php';

$cart = $_SESSION['cart'] ?? [];
$total = 0;
$items = [];

if (!empty($cart)) {
    $ids = implode(',', array_map('intval', array_keys($cart)));
    $result = $conn->query("SELECT * FROM manga WHERE id IN ($ids)");
    while ($row = $result->fetch_assoc()) {
        $row['quantity'] = $cart[$row['id']];
        $row['subtotal'] = $row['price'] * $row['quantity'];
        $total += $row['subtotal'];
        $items[] = $row;
    }
}

// Xoa san pham
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][(int)$_GET['remove']]);
    header('Location: cart.php');
    exit;
}
?>

<h2>Gio hang</h2>

<?php if (empty($items)): ?>
    <p>Gio hang trong.</p>
<?php else: ?>
<table>
    <tr><th>Manga</th><th>Gia</th><th>SL</th><th>Thanh tien</th><th></th></tr>
<?php foreach ($items as $it): ?>
    <tr>
        <td><?= e($it['title']) ?></td>
        <td><?= number_format($it['price'], 0, ',', '.') ?></td>
        <td><?= (int)$it['quantity'] ?></td>
        <td><?= number_format($it['subtotal'], 0, ',', '.') ?></td>
        <td><a href="?remove=<?= (int)$it['id'] ?>">Xoa</a></td>
    </tr>
<?php endforeach; ?>
    <tr><td colspan="3"><strong>Tong</strong></td>
        <td colspan="2"><strong><?= number_format($total, 0, ',', '.') ?> VND</strong></td></tr>
</table>
<a href="checkout.php" class="btn">Thanh toan</a>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
