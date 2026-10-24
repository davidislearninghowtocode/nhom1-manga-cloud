<?php
require_once 'config.php';
include 'includes/header.php';

$result = $conn->query("SELECT * FROM manga ORDER BY created_at DESC");
?>

<h2>Danh sach Manga</h2>
<div class="manga-grid">
<?php while ($row = $result->fetch_assoc()): ?>
    <div class="manga-card">
        <h3><?= e($row['title']) ?></h3>
        <p class="author">Tac gia: <?= e($row['author']) ?></p>
        <p class="price"><?= number_format($row['price'], 0, ',', '.') ?> VND</p>
        <p class="stock">Con lai: <?= (int)$row['stock'] ?></p>
        <a href="manga.php?id=<?= (int)$row['id'] ?>" class="btn">Xem chi tiet</a>
    </div>
<?php endwhile; ?>
</div>

<?php include 'includes/footer.php'; ?>
