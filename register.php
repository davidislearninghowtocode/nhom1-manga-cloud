<?php
require_once 'config.php';
include 'includes/header.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (strlen($username) < 3 || strlen($password) < 6) {
        $error = 'Tai khoan toi thieu 3 ky tu, mat khau toi thieu 6 ky tu';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, fullname, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $username, $hash, $fullname, $email);
        if ($stmt->execute()) {
            header('Location: /login.php');
            exit;
        } else {
            $error = 'Tai khoan da ton tai';
        }
    }
}
?>

<div class="auth-wrapper">
    <h2>Dang ky tai khoan</h2>
    <p class="subtitle">Tao tai khoan de bat dau mua sam</p>
    <div class="form-wrap">
        <?php if ($error): ?><div class="error" style="margin: 0 0 20px 0;"><?= e($error) ?></div><?php endif; ?>
        <form method="post">
            <label>Tai khoan <span class="required">*</span></label>
            <input type="text" name="username" required placeholder="Toi thieu 3 ky tu">
            <label>Mat khau <span class="required">*</span></label>
            <input type="password" name="password" required placeholder="Toi thieu 6 ky tu">
            <label>Ho ten</label>
            <input type="text" name="fullname" placeholder="Ho ten day du">
            <label>Email</label>
            <input type="email" name="email" placeholder="email@example.com">
            <button type="submit" class="btn btn-primary">Dang ky</button>
        </form>
        <p class="auth-hint">Da co tai khoan? <a href="/login.php">Dang nhap ngay</a></p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
