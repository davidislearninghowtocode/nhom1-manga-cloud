<?php
require_once 'config.php';
require_login();
include 'includes/header.php';

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    echo '<div class="container"><div class="empty-state"><h3>Gio hang trong</h3><p>Hay them san pham truoc khi thanh toan.</p><a href="/" class="btn">Mua sam ngay</a></div></div>';
    include 'includes/footer.php';
    exit;
}

$success_msg = '';
$order_id = 0;

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
        $success_msg = "Dat hang thanh cong. Ma don: #$order_id";
    } catch (Exception $ex) {
        $conn->rollback();
        $success_msg = '';
        echo '<div class="container"><div class="error">Dat hang that bai: ' . e($ex->getMessage()) . '</div></div>';
    }
}
?>

<div class="container">
    <?php if ($success_msg): ?>
        <h2 class="page-title">Dat hang thanh cong</h2>
        <div class="success"><?= e($success_msg) ?></div>
        <div class="form-wrap">
            <p style="font-size: 15px; margin-bottom: 20px;">Cam on ban da dat hang. Chung toi se lien he som nhat de xac nhan.</p>
            <div style="display: flex; gap: 10px;">
                <a href="/" class="btn btn-primary">Tiep tuc mua sam</a>
            </div>
        </div>
    <?php else: ?>
        <h2 class="page-title">Xac nhan don hang</h2>
        <div class="form-wrap">
            <p style="font-size: 15px; margin-bottom: 24px;">Ban se dat <strong><?= array_sum($cart) ?></strong> cuon manga.</p>
            <form method="post" style="background: transparent; padding: 0; border: none; max-width: none;">
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary">Xac nhan dat hang</button>
                    <a href="cart.php" class="btn btn-outline">Quay lai gio hang</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
