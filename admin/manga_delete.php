<?php
require_once __DIR__ . '/../config.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM manga WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}
header('Location: manga_list.php');
exit;
