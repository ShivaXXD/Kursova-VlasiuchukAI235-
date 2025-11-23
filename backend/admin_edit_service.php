<?php
// --- backend/admin_edit_service.php ---

// 1. "Охоронець"
require_once 'admin_auth.php';
// 2. Хедер
require_once 'admin_header.php';

// 3. Перевіряємо, чи був переданий ID
if (!isset($_GET['id'])) {
    header("Location: admin_services.php");
    exit();
}

// 4. Підключення до БД
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apex_strategies_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 5. Отримуємо ID (і перетворюємо на число для безпеки)
$service_id = intval($_GET['id']);

// 6. Отримуємо ВСІ дані для цієї послуги
$stmt = $conn->prepare("SELECT * FROM services WHERE id = ?");
$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Якщо послуги з таким ID немає
    header("Location: admin_services.php");
    exit();
}

// 7. Записуємо всі дані в змінну $service
$service = $result->fetch_assoc();

// 8. Розкодовуємо JSON зі списком "Що входить"
// і перетворюємо його назад на простий текст (кожен пункт з нового рядка)
$features_list = json_decode($service['page_features']);
$features_text = implode("\n", $features_list);

$stmt->close();
$conn->close();
?>

<main>
    <div class="admin-container">
        <h1>Редагувати послугу: "<?php echo htmlspecialchars($service['title']); ?>"</h1>
        <p>Змініть потрібні поля та натисніть "Зберегти".</p>

        <form action="admin_edit_process.php" method="POST" class="payment-form" style="max-width: 1000px;">
            
            <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">

            <fieldset style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; margin-bottom: 1.5rem;">
                <legend style="font-size: 1.2rem; font-weight: 600; padding: 0 10px;">
                    1. Вітрина (для `services.php`)
                </legend>
                <div class="form-group">
                    <label>Іконка (напр., 📈):</label>
                    <input type="text" name="icon" required value="<?php echo htmlspecialchars($service['icon']); ?>">
                </div>
                <div class="form-group">
                    <label>Назва послуги:</label>
                    <input type="text" name="title" required value="<?php echo htmlspecialchars($service['title']); ?>">
                </div>
                <div class="form-group">
                    <label>Короткий опис (для картки):</label>
                    <input type="text" name="description_short" required value="<?php echo htmlspecialchars($service['description_short']); ?>">
                </div>
                <div class="form-group">
                    <label>Ціна (тільки цифри, напр., 250):</label>
                    <input type="number" name="price" required value="<?php echo htmlspecialchars($service['price']); ?>">
                </div>
            </fieldset>

            <fieldset style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; margin-bottom: 1.5rem;">
                <legend style="font-size: 1.2rem; font-weight: 600; padding: 0 10px;">
                    2. Детальна сторінка послуги
                </legend>
                <div class="form-group">
                    <label>URL головного зображення:</label>
                    <input type="text" name="image_url" required value="<?php echo htmlspecialchars($service['image_url']); ?>">
                </div>
                <div class="form-group">
                    <label>Заголовок на сторінці (H1):</label>
                    <input type="text" name="page_title" required value="<?php echo htmlspecialchars($service['page_title']); ?>">
                </div>
                 <div class="form-group">
                    <label>Підзаголовок (H2):</label>
                    <input type="text" name="page_subtitle" required value="<?php echo htmlspecialchars($service['page_subtitle']); ?>">
                </div>
                <div class="form-group">
                    <label>Повний опис (абзац під H2):</label>
                    <textarea name="page_description" rows="4" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px;"><?php echo htmlspecialchars($service['page_description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label>
                        Список "Що входить у послугу" (кожен новий пункт з нового рядка):
                    </label>
                    <textarea name="page_features" rows="6" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px;"><?php echo htmlspecialchars($features_text); ?></textarea>
                </div>
            </fieldset>
            
            <fieldset style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; margin-bottom: 1.5rem;">
                <legend style="font-size: 1.2rem; font-weight: 600; padding: 0 10px;">
                    3. Блок "Виконує"
                </legend>
                <div class="form-group">
                    <label>Ім'я виконавця:</label>
                    <input type="text" name="performer_name" required value="<?php echo htmlspecialchars($service['performer_name']); ?>">
                </div>
                <div class="form-group">
                    <label>Роль виконавця:</label>
                    <input type="text" name="performer_role" required value="<?php echo htmlspecialchars($service['performer_role']); ?>">
                </div>
                <div class="form-group">
                    <label>URL фото виконавця:</label>
                    <input type="text" name="performer_photo_url" required value="<?php echo htmlspecialchars($service['performer_photo_url']); ?>">
                </div>
                <div class="form-group">
                    <label>Біографія виконавця (короткий опис):</label>
                    <textarea name="performer_bio" rows="3" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px;"><?php echo htmlspecialchars($service['performer_bio']); ?></textarea>
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