<?php
// --- backend/process_contact.php (ВИПРАВЛЕНО ШЛЯХ) ---

// === 1. ПІДКЛЮЧЕННЯ ДО БАЗИ ДАНИХ ===
require_once '../db.php';

// === 3. ОТРИМАННЯ ДАНИХ ===
$sender_name = $_POST['name'];
$sender_email = $_POST['email'];
$message_text = $_POST['message'];

// === 4. ПІДГОТОВКА ЗАПИТУ ===
$stmt = $conn->prepare("INSERT INTO messages (sender_name, sender_email, message_text) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $sender_name, $sender_email, $message_text);

// === 5. ВИКОНАННЯ ТА ПЕРЕНАПРАВЛЕННЯ ===
if ($stmt->execute()) {
    // --- ВИПРАВЛЕННЯ ТУТ ---
    // Було: /kursova/thankyou.html
    // Стало: /thankyou.html (або ../thankyou.html)
    header("Location: /thankyou.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>