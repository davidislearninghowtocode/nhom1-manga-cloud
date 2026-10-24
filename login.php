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

<div class="auth-wrapper">
    <h2>Dang nhap</h2>
    <p class="subtitle">Nhap thong tin de truy cap tai khoan</p>
    <div class="form-wrap">
        <?php if ($error): ?><div class="error" style="margin: 0 0 20px 0;"><?= e($error) ?></div><?php endif; ?>
        <form method="post">
            <label>Tai khoan</label>
            <input type="text" name="username" required placeholder="Nhap ten dang nhap">
            <label>Mat khau</label>
            <input type="password" name="password" required placeholder="Nhap mat khau">
            <button type="submit" class="btn btn-primary">Dang nhap</button>
        </form>
        <p class="auth-hint">Chua co tai khoan? <a href="/register.php">Dang ky ngay</a></p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
