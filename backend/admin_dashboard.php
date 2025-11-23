<?php
// --- backend/admin_dashboard.php (ОНОВЛЕНО) ---

require_once 'admin_auth.php';
require_once 'admin_header.php';

// --- Підключення до БД ---
// Використовуємо ../db.php, бо файл лежить на рівень вище (у корені)
require_once '../db.php';

// 1. Отримуємо всі ЗАМОВЛЕННЯ
$sql_orders = "SELECT * FROM orders ORDER BY order_time DESC";
$result_orders = $conn->query($sql_orders);

// 2. Отримуємо всі ПОВІДОМЛЕННЯ
$sql_messages = "SELECT * FROM messages ORDER BY received_time DESC";
$result_messages = $conn->query($sql_messages);

?>

<main>
    <div class="admin-container">
        <h1>Ласкаво просимо, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h1>
        <p>Це головна сторінка адмін-панелі. Звідси ви можете керувати вмістом сайту.</p>

        <h2>Останні замовлення </h2>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Дата</th>
                    <th>Ім'я Клієнта</th>
                    <th class="col-email">Email</th>
                    <th class="col-service">Послуга</th>
                    <th>Сума</th>
                    <th>Статус</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_orders->num_rows > 0) {
                    while($row = $result_orders->fetch_assoc()) {
                        
                        // Генеруємо посилання для кнопок
                        $toggle_url = "admin_toggle_status.php?table=orders&id=" . $row["id"];
                        $edit_url = "admin_edit_order.php?id=" . $row["id"];
                        $delete_url = "admin_delete_entry.php?table=orders&id=" . $row["id"];

                        // Перевіряємо статус "галочки"
                        if ($row["is_processed"]) {
                            $status_text = "✅ Виконано";
                            $status_class = "toggle-done";
                        } else {
                            $status_text = "⬜️ Обробити";
                            $status_class = "toggle-pending";
                        }
                        
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . date("d.m.Y H:i", strtotime($row["order_time"])) . "</td>";
                        echo "<td>" . htmlspecialchars($row["customer_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["customer_email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["service_name"]) . "</td>";
                        echo "<td>$" . $row["service_price"] . "</td>";
                        
                        // "СТАТУС" (кнопка)
                        echo "<td>
                                <a href='" . $toggle_url . "' class='action-btn " . $status_class . "'>
                                    " . $status_text . "
                                </a>
                              </td>";
                        
                        // "ДІЇ"
                        echo "<td>
                                <div class='action-links'>
                                    <a href='" . $edit_url . "' 
                                       class='action-btn' 
                                       style='background: #ffc107; color: #333;'>
                                       Редагувати
                                    </a>
                                    
                                    <a href='" . $delete_url . "' 
                                       class='action-btn delete'
                                       onclick=\"return confirm('Видалити замовлення ID " . $row["id"] . "?');\">
                                       Видалити
                                    </a>
                                </div>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Замовлень поки що немає.</td></tr>"; 
                }
                ?>
            </tbody>
        </table>

        <h2 style="margin-top: 2rem;">Повідомлення з контактної форми</h2>

        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Дата</th>
                    <th>Ім'я</th>
                    <th class="col-email">Email</th>
                    <th class="col-message">Повідомлення</th>
                    <th>Статус</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_messages->num_rows > 0) {
                    while($row = $result_messages->fetch_assoc()) {

                        $toggle_url = "admin_toggle_status.php?table=messages&id=" . $row["id"];
                        $delete_url = "admin_delete_entry.php?table=messages&id=" . $row["id"];

                        if ($row["is_processed"]) {
                            $status_text = "✅ Оброблено";
                            $status_class = "toggle-done";
                        } else {
                            $status_text = "⬜️ Відповісти";
                            $status_class = "toggle-pending";
                        }

                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . date("d.m.Y H:i", strtotime($row["received_time"])) . "</td>";
                        echo "<td>" . htmlspecialchars($row["sender_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["sender_email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["message_text"]) . "</td>";
                        
                        echo "<td>
                                <a href='" . $toggle_url . "' class='action-btn " . $status_class . "'>
                                    " . $status_text . "
                                </a>
                              </td>";
                        
                        echo "<td>
                                <div class='action-links'>
                                    <a href='" . $delete_url . "' 
                                       class='action-btn delete'
                                       onclick=\"return confirm('Видалити повідомлення ID " . $row["id"] . "?');\">
                                       Видалити
                                    </a>
                                </div>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Повідомлень поки що немає.</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div>
</main>

<?php
$conn->close();
?>
</body>
</html>