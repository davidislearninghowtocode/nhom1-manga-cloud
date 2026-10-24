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
    echo '<p>Khong tim thay.</p>';
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

<h2>Sua manga: <?= e($manga['title']) ?></h2>
<form method="post">
    <label>Ten: <input type="text" name="title" value="<?= e($manga['title']) ?>" required></label><br>
    <label>Tac gia: <input type="text" name="author" value="<?= e($manga['author']) ?>"></label><br>
    <label>Mo ta:<br><textarea name="description" rows="4" cols="40"><?= e($manga['description']) ?></textarea></label><br>
    <label>Gia: <input type="number" name="price" value="<?= $manga['price'] ?>" required></label><br>
    <label>Ton kho: <input type="number" name="stock" value="<?= (int)$manga['stock'] ?>"></label><br>
    <label>Ten file anh: <input type="text" name="image" value="<?= e($manga['image']) ?>"></label><br>
    <button type="submit" class="btn">Cap nhat</button>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
