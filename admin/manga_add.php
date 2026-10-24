<?php
require_once __DIR__ . '/../config.php';
require_admin();
include __DIR__ . '/../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = (float)($_POST['price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $image = $_POST['image'] ?? '';

    $stmt = $conn->prepare("INSERT INTO manga (title, author, description, price, stock, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssdis', $title, $author, $description, $price, $stock, $image);
    $stmt->execute();
    header('Location: manga_list.php');
    exit;
}
?>

<div class="container">
    <h2 class="page-title">Them manga moi</h2>
    <div class="form-wrap">
        <form method="post">
            <label>Ten manga <span class="required">*</span></label>
            <input type="text" name="title" required placeholder="Vi du: One Piece - Tap 1">

            <label>Tac gia</label>
            <input type="text" name="author" placeholder="Vi du: Eiichiro Oda">

            <label>Mo ta</label>
            <textarea name="description" rows="4" placeholder="Noi dung tom tat..."></textarea>

            <label>Gia (VND) <span class="required">*</span></label>
            <input type="number" name="price" step="1000" required placeholder="25000">
            <div class="form-note">Nhap gia tien theo VND</div>

            <label>So luong ton kho</label>
            <input type="number" name="stock" value="0">

            <label>Ten file anh (tuy chon)</label>
            <input type="text" name="image" placeholder="onepiece1.jpg">

            <div style="display: flex; gap: 10px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary">Luu manga</button>
                <a href="manga_list.php" class="btn btn-outline">Huy</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
