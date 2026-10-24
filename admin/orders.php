<?php
require_once __DIR__ . '/../config.php';
require_admin();
include __DIR__ . '/../includes/header.php';

$result = $conn->query("
    SELECT o.*, u.username, u.fullname
    FROM orders o
    JOIN users u ON u.id = o.user_id
    ORDER BY o.created_at DESC
");
?>

<div class="container">
    <h2 class="page-title">Danh sach don hang</h2>
    <div style="margin-bottom: 20px;">
        <a href="index.php" class="btn btn-outline btn-sm">Ve trang quan tri</a>
    </div>

    <?php if ($result->num_rows === 0): ?>
        <div class="empty-state">
            <h3>Chua co don hang nao</h3>
            <p>Don hang se hien thi tai day khi co khach dat mua.</p>
        </div>
    <?php else: ?>
    <table>
        <tr><th>Ma don</th><th>Khach hang</th><th>Tong tien</th><th>Trang thai</th><th>Ngay dat</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><strong>#<?= (int)$row['id'] ?></strong></td>
            <td><?= e($row['fullname'] ?: $row['username']) ?></td>
            <td><strong><?= number_format($row['total'], 0, ',', '.') ?> VND</strong></td>
            <td><span class="status-badge status-<?= e($row['status']) ?>"><?= e($row['status']) ?></span></td>
            <td><?= e($row['created_at']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
