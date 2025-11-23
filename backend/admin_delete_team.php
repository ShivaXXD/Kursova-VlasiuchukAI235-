<?php
// --- backend/admin_delete_team.php ---

require_once 'admin_auth.php';

if (!isset($_GET['id'])) {
    header("Location: admin_team.php");
    exit();
}

// Підключення до БД 
require_once '../db.php';

$team_id = intval($_GET['id']);

// Готуємо запит на видалення
$stmt = $conn->prepare("DELETE FROM team WHERE id = ?");
$stmt->bind_param("i", $team_id);

if ($stmt->execute()) {
    header("Location: admin_team.php");
    exit();
} else {
    echo "Помилка видалення: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>