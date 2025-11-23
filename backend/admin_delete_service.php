<?php
// --- backend/admin_delete_service.php  ---

// 1. "Охоронець" - перевіряємо, чи адмін
require_once 'admin_auth.php';

// 2. Перевіряємо, чи був переданий ID
if (!isset($_GET['id'])) {
    // Якщо ID немає, просто повертаємо на сторінку послуг
    header("Location: admin_services.php");
    exit();
}

// 3. Підключення до БД 
require_once '../db.php';

// 4. Отримуємо ID (і перетворюємо на число для безпеки)
$service_id = intval($_GET['id']);

// 5. Готуємо та виконуємо запит на видалення
$stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
$stmt->bind_param("i", $service_id);

if ($stmt->execute()) {
    header("Location: admin_services.php");
    exit();
} else {
    echo "Помилка видалення: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>