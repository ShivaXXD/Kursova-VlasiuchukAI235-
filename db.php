<?php
// db.php - Цей файл відповідає за підключення до бази

// Логіка: Якщо сайт на Render (є змінні середовища), беремо їх.
// Якщо сайт на комп'ютері (немає змінних), беремо локальні (XAMPP).

$servername = getenv('DB_HOST') ?: "localhost";
$username   = getenv('DB_USER') ?: "root";
$password   = getenv('DB_PASS') ?: "";
$dbname     = getenv('DB_NAME') ?: "apex_strategies_db"; // Твоя локальна назва
$port       = getenv('DB_PORT') ?: 3306;

// Створюємо підключення
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Перевіряємо помилки
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Встановлюємо правильне кодування для кирилиці
$conn->set_charset("utf8");
?>