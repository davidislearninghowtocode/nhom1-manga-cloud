<?php
require_once 'config.php';
include 'includes/header.php';

$result = $conn->query("SELECT * FROM manga ORDER BY created_at DESC");
?>

<section class="hero">
    <div class="hero-inner">
        <h2>Bo suu tap Manga chinh hang</h2>
        <p>Hon 100 dau manga Nhat Ban duoc nhap khau truc tiep. Mien phi van chuyen toan quoc cho don tren 200.000 VND.</p>
        <a href="#products" class="btn">Kham pha ngay</a>
    </div>
</section>

<section class="section" id="products">
    <div class="container">
        <div class="section-header">
            <h2>Danh sach Manga</h2>
            <p>Nhung dau sach moi nhat trong cua hang</p>
        </div>

        <div class="manga-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
            <a href="manga.php?id=<?= (int)$row['id'] ?>" class="manga-card">
                <div class="cover">
                    <div class="label"><?= e(str_replace(' - ', '<br>', $row['title'])) ?></div>
                </div>
                <h3><?= e($row['title']) ?></h3>
                <div class="author"><?= e($row['author']) ?></div>
                <div class="price"><?= number_format($row['price'], 0, ',', '.') ?> VND</div>
                <div class="stock">Con <?= (int)$row['stock'] ?> cuon</div>
            </a>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
