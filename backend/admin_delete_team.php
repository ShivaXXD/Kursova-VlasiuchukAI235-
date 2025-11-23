<?php
// --- backend/admin_delete_team.php ---

require_once 'admin_auth.php';

if (!isset($_GET['id'])) {
    header("Location: admin_team.php");
    exit();
}

// Підключення до БД
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apex_strategies_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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