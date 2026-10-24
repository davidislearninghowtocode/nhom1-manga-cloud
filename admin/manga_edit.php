<?php
require_once __DIR__ . '/../config.php';
require_admin();
include __DIR__ . '/../includes/header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM manga WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$manga = $stmt->get_result()->fetch_assoc();

if (!$manga) {
    echo '<div class="container"><div class="empty-state"><h3>Khong tim thay</h3><a href="manga_list.php" class="btn">Quay lai</a></div></div>';
    include __DIR__ . '/../includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("UPDATE manga SET title=?, author=?, description=?, price=?, stock=?, image=? WHERE id=?");
    $stmt->bind_param('sssdisi', $title, $author, $description, $price, $stock, $image, $id);
    $stmt->execute();
    header('Location: manga_list.php');
    exit;
}
?>

<div class="container">
    <h2 class="page-title">Sua manga: <?= e($manga['title']) ?></h2>
    <div class="form-wrap">
        <form method="post">
            <label>Ten manga <span class="required">*</span></label>
            <input type="text" name="title" value="<?= e($manga['title']) ?>" required>

            <label>Tac gia</label>
            <input type="text" name="author" value="<?= e($manga['author']) ?>">

            <label>Mo ta</label>
            <textarea name="description" rows="4"><?= e($manga['description']) ?></textarea>

            <label>Gia (VND) <span class="required">*</span></label>
            <input type="number" name="price" value="<?= $manga['price'] ?>" required>

            <label>So luong ton kho</label>
            <input type="number" name="stock" value="<?= (int)$manga['stock'] ?>">

            <label>Ten file anh</label>
            <input type="text" name="image" value="<?= e($manga['image']) ?>">

            <div style="display: flex; gap: 10px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary">Cap nhat</button>
                <a href="manga_list.php" class="btn btn-outline">Huy</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
