<?php
session_start();

// ===== CAU HINH KET NOI DATABASE =====
// Doi IP neu DB01 co IP khac
$DB_HOST = '192.168.1.20';   // IP cua DB01
$DB_PORT = 3306;
$DB_NAME = 'manga_shop';
$DB_USER = 'webuser';
$DB_PASS = 'Web@2026';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);

if ($conn->connect_error) {
    die('Khong ket noi duoc database: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');

// Ham tien ich
function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login.php');
        exit;
    }
}

function require_admin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: /login.php');
        exit;
    }
}
?>
