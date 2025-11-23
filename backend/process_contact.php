<?php
// --- backend/process_contact.php (ОНОВЛЕНО) ---

// === 1. ПІДКЛЮЧЕННЯ ДО БАЗИ ДАНИХ ===
require_once '../db.php';

// === 3. ОТРИМАННЯ ДАНИХ З ФОРМИ ===
// Ми отримуємо дані, які відправив 'contacts.html' методом POST
$sender_name = $_POST['name'];
$sender_email = $_POST['email'];
$message_text = $_POST['message'];

// === 4. ПІДГОТОВКА ЗАПИТУ (ЗАХИСТ ВІД SQL-ІН'ЄКЦІЙ) ===
// Це вимога з методички про безпеку
// Ми не вставляємо дані напряму, а використовуємо '?'
$stmt = $conn->prepare("INSERT INTO messages (sender_name, sender_email, message_text) VALUES (?, ?, ?)");

// 'sss' означає, що всі три змінні - це рядки (string)
$stmt->bind_param("sss", $sender_name, $sender_email, $message_text);

// === 5. ВИКОНАННЯ ЗАПИТУ ТА ПЕРЕНАПРАВЛЕННЯ ===
if ($stmt->execute()) {
    // Якщо дані успішно збережено, перенаправляємо на 'thankyou.html'
    // Важливо: header() спрацює, тільки якщо до цього не було ніякого HTML-виводу
    header("Location: /kursova/thankyou.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// === 6. ЗАКРИТТЯ З'ЄДНАНЬ ===
$stmt->close();
$conn->close();
?>