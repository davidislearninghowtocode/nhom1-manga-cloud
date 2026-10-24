<?php
require_once __DIR__ . '/../config.php';
require_admin();
include __DIR__ . '/../includes/header.php';

$result = $conn->query("SELECT * FROM manga ORDER BY id DESC");
?>

<h2>Danh sach Manga</h2>
<a href="manga_add.php" class="btn">Them manga moi</a>

<table>
    <tr><th>ID</th><th>Ten</th><th>Tac gia</th><th>Gia</th><th>Ton kho</th><th>Thao tac</th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= (int)$row['id'] ?></td>
        <td><?= e($row['title']) ?></td>
        <td><?= e($row['author']) ?></td>
        <td><?= number_format($row['price'], 0, ',', '.') ?></td>
        <td><?= (int)$row['stock'] ?></td>
        <td>
            <a href="manga_edit.php?id=<?= (int)$row['id'] ?>">Sua</a> |
            <a href="manga_delete.php?id=<?= (int)$row['id'] ?>" onclick="return confirm('Xoa manga nay?')">Xoa</a>
        </td>
    </tr>
<?php endwhile; ?>
</table>

<?php include __DIR__ . '/../includes/footer.php'; ?>
