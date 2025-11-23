<?php
// --- backend/admin_services.php (ОНОВЛЕНО з Редагуванням) ---

// "Охоронець"
require_once 'admin_auth.php';
// Хедер
require_once 'admin_header.php';

// Підключення до БД (ОНОВЛЕНО)
require_once '../db.php';

// Отримуємо всі послуги з бази
$sql_services = "SELECT id, icon, title, price FROM services ORDER BY id ASC";
$result_services = $conn->query($sql_services);
?>

<main>
    <div class="admin-container">
        <h1>Керування Послугами</h1>
        <p>Тут ви можете бачити, додавати, редагувати та видаляти послуги.</p>

        <a href="admin_add_service.php" class="btn" style="background: #28a745; margin-bottom: 1.5rem;">
            + Додати нову послугу
        </a>

        <h2 style="margin-top: 1rem;">Список актуальних послуг</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Іконка</th>
                    <th>Назва</th>
                    <th>Ціна</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_services->num_rows > 0) {
                    while($row = $result_services->fetch_assoc()) {
                        
                        $edit_url = "admin_edit_service.php?id=" . $row["id"];
                        $delete_url = "admin_delete_service.php?id=" . $row["id"];

                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["icon"] . "</td>";
                        echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                        echo "<td>$" . $row["price"] . "</td>";
                        
                        echo "<td>
                                <a href='" . $edit_url . "' 
                                   style='color: #007BFF; font-weight: bold; margin-right: 15px;'>
                                   Редагувати
                                </a>
                                
                                <a href='" . $delete_url . "' 
                                   style='color: red; font-weight: bold;'
                                   onclick=\"return confirm('Ви впевнені, що хочете видалити послугу: " . htmlspecialchars($row["title"]) . "?');\">
                                   Видалити
                                </a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Послуг у базі даних не знайдено.</td></tr>";
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