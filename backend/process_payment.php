<?php
// --- backend/process_payment.php (ОНОВЛЕНО) ---

// === 1. ПІДКЛЮЧЕННЯ ДО БАЗИ ДАНИХ ===
require_once '../db.php';

// === 3. ОТРИМАННЯ ДАНИХ З ФОРМИ ===
$customer_name = $_POST['customer_name'];
$customer_email = $_POST['customer_email'];

// Отримуємо дані з прихованих полів, які ми додали через JS
$service_name = $_POST['service_name_php'];
$service_price = $_POST['service_price_php'];

/* * ВАЖЛИВО (Вимога безпеки з методички):
* Ми свідомо НЕ отримуємо і НЕ зберігаємо дані картки:
* $_POST['card_number']
* $_POST['card_expiry']
* $_POST['card_cvv']
* Вони відправляються з форми, але наш backend їх просто ігнорує.
* Це і є "Безпечна імітація".
*/

// === 4. ПІДГОТОВКА ЗАПИТУ (ЗАХИСТ ВІД SQL-ІН'ЄКЦІЙ) ===
$stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_email, service_name, service_price) VALUES (?, ?, ?, ?)");

// 'sssi' означає: string, string, string, integer (ціна)
$stmt->bind_param("sssi", $customer_name, $customer_email, $service_name, $service_price);

// === 5. ВИКОНАННЯ ЗАПИТУ ТА ПЕРЕНАПРАВЛЕННЯ ===
if ($stmt->execute()) {
    // Успішно! Тепер отримуємо ID щойно створеного замовлення
    $order_id = $conn->insert_id;

    // Перенаправляємо користувача на сторінку чеку, 
    // передаючи цей унікальний ID в URL (через GET-запит)
    header("Location: /kursova/backend/receipt.php?order_id=" . $order_id);
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// === 6. ЗАКРИТТЯ З'ЄДНАНЬ ===
$stmt->close();
$conn->close();
?>