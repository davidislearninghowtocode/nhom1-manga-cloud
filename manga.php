<?php
require_once 'config.php';
include 'includes/header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM manga WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$manga = $stmt->get_result()->fetch_assoc();

if (!$manga) {
    echo '<div class="container"><div class="empty-state"><h3>Khong tim thay manga</h3><p>San pham ban dang tim khong ton tai.</p><a href="/" class="btn">Ve trang chu</a></div></div>';
    include 'includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qty = max(1, (int)($_POST['quantity'] ?? 1));
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;
    header('Location: cart.php');
    exit;
}
?>

<div class="container">
    <article class="manga-detail">
        <div class="detail-cover">
            <div class="label"><?= e(str_replace(' - ', '<br>', $manga['title'])) ?></div>
        </div>
        <div class="detail-info">
            <div class="breadcrumb">Trang chu / Manga / <?= e($manga['title']) ?></div>
            <h2><?= e($manga['title']) ?></h2>
            <div class="author">Tac gia: <?= e($manga['author']) ?></div>

            <?php if ($manga['stock'] > 0): ?>
                <div class="stock-badge">Con hang - <?= (int)$manga['stock'] ?> cuon</div>
            <?php else: ?>
                <div class="stock-badge" style="background:#fee2e2;color:#991b1b;">Het hang</div>
            <?php endif; ?>

            <div class="price-large"><?= number_format($manga['price'], 0, ',', '.') ?> VND</div>
            <div class="description"><?= nl2br(e($manga['description'])) ?></div>

            <?php if ($manga['stock'] > 0): ?>
            <form method="post">
                <div class="qty-row">
                    <label>So luong</label>
                    <input type="number" name="quantity" value="1" min="1" max="<?= (int)$manga['stock'] ?>">
                </div>
                <div class="action-row">
                    <button type="submit" class="btn btn-block">Them vao gio hang</button>
                    <a href="/" class="btn btn-outline btn-block">Tiep tuc xem</a>
                </div>
            </form>
            <?php else: ?>
            <a href="/" class="btn btn-outline">Ve trang chu</a>
            <?php endif; ?>
        </div>
    </article>
</div>

<?php include 'includes/footer.php'; ?>
