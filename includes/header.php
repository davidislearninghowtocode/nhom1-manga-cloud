<?php require_once __DIR__ . '/../config.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Manga Shop - Nhom 1 ICTU</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header>
    <div class="container">
        <h1><a href="/">Manga Shop</a></h1>
        <nav>
            <a href="/">Trang chu</a>
            <a href="/cart.php">Gio hang
                (<?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?>)
            </a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <span>Xin chao, <?= e($_SESSION['username']) ?></span>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="/admin/index.php">Quan tri</a>
                <?php endif; ?>
                <a href="/logout.php">Dang xuat</a>
            <?php else: ?>
                <a href="/login.php">Dang nhap</a>
                <a href="/register.php">Dang ky</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container">
