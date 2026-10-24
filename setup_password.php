<?php
// =============================================
// FILE SETUP MAT KHAU - CHAY MOT LAN DUY NHAT
// Sau khi chay thanh cong, HAY XOA FILE NAY NGAY
// =============================================

require_once 'config.php';

$admin_pass = password_hash('Admin@2026', PASSWORD_DEFAULT);
$demo_pass = password_hash('Demo@2026', PASSWORD_DEFAULT);

$ok1 = $conn->query("UPDATE users SET password = '$admin_pass' WHERE username = 'admin'");
$ok2 = $conn->query("UPDATE users SET password = '$demo_pass' WHERE username = 'demo'");

echo "<h2>Setup mat khau</h2>";
echo "<p>Admin: " . ($ok1 ? 'OK' : 'FAIL') . "</p>";
echo "<p>Demo: " . ($ok2 ? 'OK' : 'FAIL') . "</p>";
echo "<hr>";
echo "<p><strong>Tai khoan dang nhap:</strong></p>";
echo "<ul>";
echo "<li>admin / Admin@2026 (quyen quan tri)</li>";
echo "<li>demo / Demo@2026 (quyen khach)</li>";
echo "</ul>";
echo "<p style='color:red; font-weight:bold;'>HAY XOA FILE setup_password.php NGAY SAU KHI CHAY!</p>";
?>
