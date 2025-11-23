<?php
// --- backend/admin_edit_order_process.php  ---

// 1. "Охоронець"
require_once 'admin_auth.php';

// 2. Перевіряємо, чи дані прийшли методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. Підключення до БД 
    require_once '../db.php';

    // 4. Отримуємо ВСІ дані з форми
    $order_id = $_POST['order_id'];
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $service_name = $_POST['service_name'];
    $service_price = $_POST['service_price'];

    // 5. Готуємо запит на ОНОВЛЕННЯ 
    $stmt = $conn->prepare("UPDATE orders SET 
        customer_name = ?, 
        customer_email = ?, 
        service_name = ?, 
        service_price = ?
        WHERE id = ?");
    
    // 'sssii' - 3 рядки, 2 числа (ціна та id)
    $stmt->bind_param("sssii", 
        $customer_name, $customer_email, $service_name, $service_price, $order_id
    );

    // 6. Виконуємо і перенаправляємо
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Помилка оновлення замовлення: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: admin_dashboard.php");
    exit();
}
?>