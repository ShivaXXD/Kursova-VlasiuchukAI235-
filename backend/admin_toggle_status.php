<?php
// --- backend/admin_toggle_status.php  ---

require_once 'admin_auth.php';

// Перевіряємо, чи є ID та назва таблиці
if (!isset($_GET['id']) || !isset($_GET['table'])) {
    header("Location: admin_dashboard.php");
    exit();
}

// 1. Безпечно отримуємо дані
$id = intval($_GET['id']);
$table = $_GET['table'];

// 2. "Білий список" таблиць, щоб уникнути SQL-ін'єкції
if ($table !== 'orders' && $table !== 'messages') {
    die("Недопустима таблиця.");
}

// 3. Підключення до БД 
require_once '../db.php';

// 4. Магічний запит, який "перевертає" значення:
// (SET is_processed = NOT is_processed) - це як (0 стає 1) або (1 стає 0)
$stmt = $conn->prepare("UPDATE `$table` SET is_processed = NOT is_processed WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conn->close();

// 5. Повертаємо адміна назад
header("Location: admin_dashboard.php");
exit();

?>