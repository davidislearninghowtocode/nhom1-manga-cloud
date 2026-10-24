<?php
require_once __DIR__ . '/../config.php';
require_admin();
include __DIR__ . '/../includes/header.php';

$result = $conn->query("SELECT * FROM manga ORDER BY id DESC");
?>

<div class="container">
    <h2 class="page-title">Quan ly Manga</h2>
    <div style="margin-bottom: 20px; display: flex; gap: 10px;">
        <a href="manga_add.php" class="btn btn-primary btn-sm">Them manga moi</a>
        <a href="index.php" class="btn btn-outline btn-sm">Ve trang quan tri</a>
    </div>

    <table>
        <tr><th>ID</th><th>Ten</th><th>Tac gia</th><th>Gia (VND)</th><th>Ton kho</th><th></th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td>#<?= (int)$row['id'] ?></td>
            <td><strong><?= e($row['title']) ?></strong></td>
            <td><?= e($row['author']) ?></td>
            <td><?= number_format($row['price'], 0, ',', '.') ?></td>
            <td><?= (int)$row['stock'] ?></td>
            <td>
                <a href="manga_edit.php?id=<?= (int)$row['id'] ?>" class="action-link">Sua</a>
                <a href="manga_delete.php?id=<?= (int)$row['id'] ?>" onclick="return confirm('Xoa manga nay?')" class="action-link delete">Xoa</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
