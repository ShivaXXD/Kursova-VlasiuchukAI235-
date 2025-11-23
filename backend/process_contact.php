<?php
// --- backend/process_contact.php ---

// === 1. КОНФІГУРАЦІЯ БАЗИ ДАНИХ ===
$servername = "localhost";
$username = "root";       // Стандартний логін для XAMPP
$password = "";           // Стандартний пароль (порожній) для XAMPP
$dbname = "apex_strategies_db"; // Назва вашої БД

// === 2. СТВОРЕННЯ З'ЄДНАННЯ ===
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка з'єднання
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// === 3. ОТРИМАННЯ ДАНИХ З ФОРМИ ===
// Ми отримуємо дані, які відправив 'contacts.html' методом POST
$sender_name = $_POST['name'];
$sender_email = $_POST['email'];
$message_text = $_POST['message'];

// === 4. ПІДГОТОВКА ЗАПИТУ (ЗАХИСТ ВІД SQL-ІН'ЄКЦІЙ) ===
// Це вимога з методички про безпеку [cite: 703]
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