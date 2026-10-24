<?php
require_once 'config.php';
include 'includes/header.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: /');
        exit;
    } else {
        $error = 'Sai tai khoan hoac mat khau';
    }
}
?>

<h2>Dang nhap</h2>
<?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<form method="post">
    <label>Tai khoan: <input type="text" name="username" required></label><br>
    <label>Mat khau: <input type="password" name="password" required></label><br>
    <button type="submit" class="btn">Dang nhap</button>
</form>

<?php include 'includes/footer.php'; ?>
