<?php
// --- backend/admin_delete_entry.php  ---

require_once 'admin_auth.php';

// Перевіряємо, чи є ID та назва таблиці
if (!isset($_GET['id']) || !isset($_GET['table'])) {
    header("Location: admin_dashboard.php");
    exit();
}

// 1. Безпечно отримуємо дані
$id = intval($_GET['id']);
$table = $_GET['table'];

// 2. "Білий список" таблиць
if ($table !== 'orders' && $table !== 'messages') {
    die("Недопустима таблиця.");
}

// 3. Підключення до БД
require_once '../db.php';

// 4. Готуємо запит на видалення
$stmt = $conn->prepare("DELETE FROM `$table` WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conn->close();

// 5. Повертаємо адміна назад
header("Location: admin_dashboard.php");
exit();

?>