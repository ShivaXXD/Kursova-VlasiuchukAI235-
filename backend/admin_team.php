<?php
// --- backend/admin_team.php  ---

// "Охоронець"
require_once 'admin_auth.php';
// Хедер
require_once 'admin_header.php';

// Підключення до БД 
require_once '../db.php';

// Отримуємо всіх членів команди з бази
$sql_team = "SELECT id, name, role_short FROM team ORDER BY id ASC";
$result_team = $conn->query($sql_team);
?>

<main>
    <div class="admin-container">
        <h1>Керування Командою</h1>
        <p>Тут ви можете бачити, додавати, редагувати та видаляти членів команди.</p>

        <a href="admin_add_team.php" class="btn" style="background: #28a745; margin-bottom: 1.5rem;">
            + Додати нового співробітника
        </a>

        <h2 style="margin-top: 1rem;">Список співробітників</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ім'я</th>
                    <th>Роль (коротка)</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_team->num_rows > 0) {
                    while($row = $result_team->fetch_assoc()) {
                        
                        $edit_url = "admin_edit_team.php?id=" . $row["id"];
                        $delete_url = "admin_delete_team.php?id=" . $row["id"];

                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["role_short"]) . "</td>";
                        echo "<td>
                                <a href='" . $edit_url . "' 
                                   style='color: #007BFF; font-weight: bold; margin-right: 15px;'>
                                   Редагувати
                                </a>
                                
                                <a href='" . $delete_url . "' 
                                   style='color: red; font-weight: bold;'
                                   onclick=\"return confirm('Ви впевнені, що хочете видалити: " . htmlspecialchars($row["name"]) . "?');\">
                                   Видалити
                                </a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Співробітників у базі даних не знайдено.</td></tr>";
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