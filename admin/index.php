<?php
require_once __DIR__ . '/../config.php';
require_admin();
include __DIR__ . '/../includes/header.php';

$stats = [
    'manga' => $conn->query("SELECT COUNT(*) c FROM manga")->fetch_assoc()['c'],
    'orders' => $conn->query("SELECT COUNT(*) c FROM orders")->fetch_assoc()['c'],
    'users' => $conn->query("SELECT COUNT(*) c FROM users")->fetch_assoc()['c'],
    'revenue' => $conn->query("SELECT COALESCE(SUM(total),0) s FROM orders")->fetch_assoc()['s'],
];
?>

<div class="container">
    <h2 class="page-title">Trang quan tri</h2>

    <div class="admin-stats">
        <div class="stat-card">
            <div class="label">Dau sach</div>
            <div class="value"><?= (int)$stats['manga'] ?></div>
        </div>
        <div class="stat-card">
            <div class="label">Don hang</div>
            <div class="value"><?= (int)$stats['orders'] ?></div>
        </div>
        <div class="stat-card">
            <div class="label">Nguoi dung</div>
            <div class="value"><?= (int)$stats['users'] ?></div>
        </div>
        <div class="stat-card">
            <div class="label">Doanh thu (VND)</div>
            <div class="value"><?= number_format($stats['revenue'], 0, ',', '.') ?></div>
        </div>
    </div>

    <h2 class="page-title">Chuc nang quan tri</h2>
    <div class="admin-nav-grid">
        <a href="manga_list.php" class="admin-nav-card">
            <h3>Quan ly Manga</h3>
            <p>Them, sua, xoa manga trong kho</p>
        </a>
        <a href="orders.php" class="admin-nav-card">
            <h3>Danh sach don hang</h3>
            <p>Xem va cap nhat trang thai don</p>
        </a>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
