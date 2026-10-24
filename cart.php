<?php
require_once 'config.php';
include 'includes/header.php';

if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][(int)$_GET['remove']]);
    header('Location: cart.php');
    exit;
}

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
?>

<div class="container">
    <h2 class="page-title">Gio hang cua ban</h2>

    <?php if (empty($items)): ?>
        <div class="empty-state">
            <h3>Gio hang cua ban dang trong</h3>
            <p>Them san pham vao gio de bat dau mua sam.</p>
            <a href="/" class="btn">Mua sam ngay</a>
        </div>
    <?php else: ?>
    <table>
        <tr><th>San pham</th><th>Gia</th><th>So luong</th><th>Thanh tien</th><th></th></tr>
        <?php foreach ($items as $it): ?>
        <tr>
            <td><strong><?= e($it['title']) ?></strong></td>
            <td><?= number_format($it['price'], 0, ',', '.') ?> VND</td>
            <td><?= (int)$it['quantity'] ?></td>
            <td><?= number_format($it['subtotal'], 0, ',', '.') ?> VND</td>
            <td><a href="?remove=<?= (int)$it['id'] ?>" class="action-link delete">Xoa</a></td>
        </tr>
        <?php endforeach; ?>
        <tr class="cart-total">
            <td colspan="3">TONG CONG</td>
            <td colspan="2"><?= number_format($total, 0, ',', '.') ?> VND</td>
        </tr>
    </table>
    <div style="margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
        <a href="/" class="btn btn-outline">Tiep tuc mua sam</a>
        <a href="checkout.php" class="btn btn-primary">Thanh toan ngay</a>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
