<?php
// db.php - Підключення з підтримкою SSL для TiDB

$host = getenv('DB_HOST') ?: "localhost";
$user = getenv('DB_USER') ?: "root";
$pass = getenv('DB_PASS') ?: "";
$db   = getenv('DB_NAME') ?: "apex_strategies_db";
$port = getenv('DB_PORT') ?: 3306;

// 1. Ініціалізуємо об'єкт MySQLi
$conn = mysqli_init();

// 2. Включаємо налаштування SSL
// Перші NULL означають, що ми використовуємо стандартні сертифікати сервера,
// а останній рядок налаштовує перевірку.
$conn->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
$conn->ssl_set(NULL, NULL, NULL, NULL, NULL);

// 3. Пробуємо підключитися
// Прапор MYSQLI_CLIENT_SSL є обов'язковим для TiDB
$connected = @$conn->real_connect($host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL);

// 4. Перевіряємо помилки
if (!$connected) {
    // Виводимо детальнішу помилку
    die("Connect Error (" . mysqli_connect_errno() . ") " . mysqli_connect_error());
}

// 5. Встановлюємо кодування
$conn->set_charset("utf8");

?>