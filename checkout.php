<?php
require_once 'config.php';
require_login();
include 'includes/header.php';

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    echo '<p>Gio hang trong.</p>';
    include 'includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->begin_transaction();
    try {
        $ids = implode(',', array_map('intval', array_keys($cart)));
        $result = $conn->query("SELECT id, price FROM manga WHERE id IN ($ids)");

        $total = 0;
        $lines = [];
        while ($row = $result->fetch_assoc()) {
            $qty = $cart[$row['id']];
            $total += $row['price'] * $qty;
            $lines[] = [$row['id'], $qty, $row['price']];
        }

        $stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
        $stmt->bind_param('id', $_SESSION['user_id'], $total);
        $stmt->execute();
        $order_id = $conn->insert_id;

        $stmt = $conn->prepare("INSERT INTO order_items (order_id, manga_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($lines as [$mid, $q, $p]) {
            $stmt->bind_param('iiid', $order_id, $mid, $q, $p);
            $stmt->execute();

            $conn->query("UPDATE manga SET stock = stock - $q WHERE id = $mid");
        }

        $conn->commit();
        unset($_SESSION['cart']);
        echo '<p class="success">Dat hang thanh cong! Ma don: #' . $order_id . '</p>';
    } catch (Exception $ex) {
        $conn->rollback();
        echo '<p class="error">Dat hang that bai: ' . e($ex->getMessage()) . '</p>';
    }
} else {
?>
<h2>Xac nhan don hang</h2>
<p>Ban se dat <?= array_sum($cart) ?> cuon manga.</p>
<form method="post">
    <button type="submit" class="btn">Xac nhan dat hang</button>
</form>
<?php }
include 'includes/footer.php';
?>
