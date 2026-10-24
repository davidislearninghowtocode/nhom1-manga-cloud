<?php require_once __DIR__ . '/../config.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga Shop</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<div class="announcement">Mien phi van chuyen cho don hang tren 200.000 VND</div>

<header>
    <div class="container">
        <a href="/" class="logo">Manga Shop</a>
        <nav class="main-nav">
            <a href="/">Trang chu</a>
            <a href="/?filter=new">Moi nhat</a>
            <a href="/?filter=bestseller">Ban chay</a>
            <a href="#">Lien he</a>
        </nav>
        <div class="user-actions">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span><?= e($_SESSION['username']) ?></span>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="/admin/index.php">Quan tri</a>
                <?php endif; ?>
                <a href="/logout.php">Dang xuat</a>
            <?php else: ?>
                <a href="/login.php">Dang nhap</a>
                <a href="/register.php">Dang ky</a>
            <?php endif; ?>
            <a href="/cart.php" class="cart-link">
                Gio hang
                <span class="cart-count"><?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?></span>
            </a>
        </div>
    </div>
</header>

<main>
