<?php
// --- backend/admin_edit_team.php  ---
require_once 'admin_auth.php';
require_once 'admin_header.php';

if (!isset($_GET['id'])) {
    header("Location: admin_team.php");
    exit();
}

// Підключення до БД 
require_once '../db.php';

$team_id = intval($_GET['id']);

// Отримуємо дані для цього співробітника
$stmt = $conn->prepare("SELECT * FROM team WHERE id = ?");
$stmt->bind_param("i", $team_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: admin_team.php");
    exit();
}

$member = $result->fetch_assoc();

// Розкодовуємо JSON
$competencies_list = json_decode($member['competencies']);
$competencies_text = implode("\n", $competencies_list);

$stmt->close();
$conn->close();
?>

<main>
    <div class="admin-container">
        <h1>Редагувати співробітника: <?php echo htmlspecialchars($member['name']); ?></h1>
        
        <form action="admin_edit_team_process.php" method="POST" class="payment-form" style="max-width: 1000px;">
            
            <input type="hidden" name="team_id" value="<?php echo $member['id']; ?>">

            <fieldset style="border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
                <div class="form-group">
                    <label>Ім'я:</label>
                    <input type="text" name="name" required value="<?php echo htmlspecialchars($member['name']); ?>">
                </div>
                <div class="form-group">
                    <label>URL фото:</label>
                    <input type="text" name="photo_url" required value="<?php echo htmlspecialchars($member['photo_url']); ?>">
                </div>
                <div class="form-group">
                    <label>Коротка роль (для `index.php`):</label>
                    <input type="text" name="role_short" required value="<?php echo htmlspecialchars($member['role_short']); ?>">
                </div>
                <div class="form-group">
                    <label>Повна роль (для `team.php`):</label>
                    <input type="text" name="role_full" required value="<?php echo htmlspecialchars($member['role_full']); ?>">
                </div>
                <div class="form-group">
                    <label>Коротка біографія (для `index.php`):</label>
                    <textarea name="bio_short" rows="3" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px;"><?php echo htmlspecialchars($member['bio_short']); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Повна біографія (для `team.php`):</label>
                    <textarea name="bio_full" rows="5" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px;"><?php echo htmlspecialchars($member['bio_full']); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Компетенції (кожна з нового рядка):</label>
                    <textarea name="competencies" rows="5" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px;"><?php echo htmlspecialchars($competencies_text); ?></textarea>
                </div>
            </fieldset>

            <button type="submit" class="btn" style="width: 100%; background: #007BFF; margin-top: 1.5rem;">
                Зберегти зміни
            </button>

        </form>
    </div>
</main>

</body>
</html>