<?php
// --- backend/process_payment.php (ВИПРАВЛЕНО ШЛЯХ) ---

// === 1. ПІДКЛЮЧЕННЯ ДО БАЗИ ДАНИХ ===
require_once '../db.php';

// === 3. ОТРИМАННЯ ДАНИХ З ФОРМИ ===
$customer_name = $_POST['customer_name'];
$customer_email = $_POST['customer_email'];
$service_name = $_POST['service_name_php'];
$service_price = $_POST['service_price_php'];

// === 4. ПІДГОТОВКА ЗАПИТУ ===
$stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_email, service_name, service_price) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $customer_name, $customer_email, $service_name, $service_price);

// === 5. ВИКОНАННЯ ЗАПИТУ ТА ПЕРЕНАПРАВЛЕННЯ ===
if ($stmt->execute()) {
    $order_id = $conn->insert_id;

    // --- ВИПРАВЛЕННЯ ТУТ ---
    // Було: /kursova/backend/receipt.php...
    // Стало: receipt.php... (просто назва файлу поруч)
    header("Location: receipt.php?order_id=" . $order_id); 
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>