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

<h2>Them manga moi</h2>
<form method="post">
    <label>Ten: <input type="text" name="title" required></label><br>
    <label>Tac gia: <input type="text" name="author"></label><br>
    <label>Mo ta:<br><textarea name="description" rows="4" cols="40"></textarea></label><br>
    <label>Gia (VND): <input type="number" name="price" step="1000" required></label><br>
    <label>Ton kho: <input type="number" name="stock" value="0"></label><br>
    <label>Ten file anh: <input type="text" name="image"></label><br>
    <button type="submit" class="btn">Luu</button>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
