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

<h2>Dang ky</h2>
<?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<form method="post">
    <label>Tai khoan: <input type="text" name="username" required></label><br>
    <label>Mat khau: <input type="password" name="password" required></label><br>
    <label>Ho ten: <input type="text" name="fullname"></label><br>
    <label>Email: <input type="email" name="email"></label><br>
    <button type="submit" class="btn">Dang ky</button>
</form>

<?php include 'includes/footer.php'; ?>
