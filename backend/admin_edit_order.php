<?php
// --- backend/admin_edit_order.php  ---

// 1. "Охоронець"
require_once 'admin_auth.php';
// 2. Хедер
require_once 'admin_header.php';

// 3. Перевіряємо, чи був переданий ID
if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

// 4. Підключення до БД 
require_once '../db.php';

// 5. Отримуємо ID
$order_id = intval($_GET['id']);

// 6. Отримуємо ВСІ дані для цього замовлення
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Якщо замовлення з таким ID немає
    header("Location: admin_dashboard.php");
    exit();
}

// 7. Записуємо дані в змінну $order
$order = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<main>
    <div class="admin-container">
        <h1>Редагувати Замовлення #<?php echo $order['id']; ?></h1>
        <p>
            Ви можете змінити деталі цього замовлення. 
        </p>

        <form action="admin_edit_order_process.php" method="POST" class="payment-form" style="max-width: 1000px;">
            
            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">

            <fieldset style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; margin-bottom: 1.5rem;">
                <legend style="font-size: 1.2rem; font-weight: 600; padding: 0 10px;">
                    Дані клієнта
                </legend>
                <div class="form-group">
                    <label>Ім'я Клієнта:</label>
                    <input type="text" name="customer_name" required value="<?php echo htmlspecialchars($order['customer_name']); ?>">
                </div>
                <div class="form-group">
                    <label>Email Клієнта:</label>
                    <input type="email" name="customer_email" required value="<?php echo htmlspecialchars($order['customer_email']); ?>">
                </div>
            </fieldset>

            <fieldset style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; margin-bottom: 1.5rem;">
                <legend style="font-size: 1.2rem; font-weight: 600; padding: 0 10px;">
                    Дані послуги
                </legend>
                <div class="form-group">
                    <label>Назва послуги:</label>
                    <input type="text" name="service_name" required value="<?php echo htmlspecialchars($order['service_name']); ?>">
                </div>
                <div class="form-group">
                    <label>Сума (тільки цифри):</label>
                    <input type="number" name="service_price" required value="<?php echo htmlspecialchars($order['service_price']); ?>">
                </div>
            </fieldset>

            <button type="submit" class="btn" style="width: 100%; background: #007BFF;">
                Зберегти зміни
            </button>

        </form>
    </div>
</main>

</body>
</html>