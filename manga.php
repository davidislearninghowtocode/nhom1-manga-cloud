<?php
require_once 'config.php';
include 'includes/header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM manga WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$manga = $stmt->get_result()->fetch_assoc();

if (!$manga) {
    echo '<p>Khong tim thay manga.</p>';
    include 'includes/footer.php';
    exit;
}

// Xu ly them vao gio
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qty = max(1, (int)($_POST['quantity'] ?? 1));
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;
    header('Location: cart.php');
    exit;
}
?>

<article class="manga-detail">
    <h2><?= e($manga['title']) ?></h2>
    <p><strong>Tac gia:</strong> <?= e($manga['author']) ?></p>
    <p><strong>Gia:</strong> <?= number_format($manga['price'], 0, ',', '.') ?> VND</p>
    <p><strong>Ton kho:</strong> <?= (int)$manga['stock'] ?></p>
    <p><?= nl2br(e($manga['description'])) ?></p>

    <form method="post">
        <label>So luong:
            <input type="number" name="quantity" value="1" min="1" max="<?= (int)$manga['stock'] ?>">
        </label>
        <button type="submit" class="btn">Them vao gio</button>
    </form>
</article>

<?php include 'includes/footer.php'; ?>
