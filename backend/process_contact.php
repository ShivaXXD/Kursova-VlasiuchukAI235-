<?php
// --- backend/process_contact.php  ---

// === 1. ПІДКЛЮЧЕННЯ ДО БАЗИ ДАНИХ ===
require_once '../db.php';

// === 2. ОТРИМАННЯ ДАНИХ ===
$sender_name = $_POST['name'];
$sender_email = $_POST['email'];
$message_text = $_POST['message'];

// === 3. ПІДГОТОВКА ЗАПИТУ ===
$stmt = $conn->prepare("INSERT INTO messages (sender_name, sender_email, message_text) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $sender_name, $sender_email, $message_text);

// === 4. ВИКОНАННЯ ТА ПЕРЕНАПРАВЛЕННЯ ===
if ($stmt->execute()) {
    header("Location: /thankyou.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>