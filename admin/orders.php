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

<h2>Danh sach don hang</h2>
<table>
    <tr><th>#</th><th>Khach</th><th>Tong</th><th>Trang thai</th><th>Ngay</th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= (int)$row['id'] ?></td>
        <td><?= e($row['fullname'] ?: $row['username']) ?></td>
        <td><?= number_format($row['total'], 0, ',', '.') ?></td>
        <td><?= e($row['status']) ?></td>
        <td><?= e($row['created_at']) ?></td>
    </tr>
<?php endwhile; ?>
</table>

<?php include __DIR__ . '/../includes/footer.php'; ?>
