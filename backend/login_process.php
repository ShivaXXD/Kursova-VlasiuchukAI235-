<?php
// --- backend/login_process.php ---

// Запускаємо сесію. Це має бути НАЙПЕРШИЙ рядок у файлі.
session_start();

// --- Конфігурація бази ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apex_strategies_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 1. Отримуємо дані з форми
$login_user = $_POST['username'];
$login_pass = $_POST['password'];

// 2. Шукаємо користувача з таким логіном
$stmt = $conn->prepare("SELECT password_hash FROM admins WHERE username = ?");
$stmt->bind_param("s", $login_user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // Користувач існує, перевіряємо пароль
    $admin = $result->fetch_assoc();
    $hashed_password = $admin['password_hash'];

    // 3. Функція password_verify() порівнює введений пароль з хешем у базі
    if (password_verify($login_pass, $hashed_password)) {
        
        // ПАРОЛЬ ПРАВИЛЬНИЙ!
        // 4. Записуємо в сесію, що користувач авторизований
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $login_user;

        // 5. Перенаправляємо на головну сторінку адмінки
        // (Ми створимо цей файл у наступному кроці)
        header("Location: admin_dashboard.php");
        exit();

    }
}

// Якщо логін не знайдено, або пароль невірний,
// кидаємо назад на сторінку логіну
header("Location: ../login.html");
exit();
?>