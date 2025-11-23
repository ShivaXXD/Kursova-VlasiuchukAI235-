<?php
// --- backend/admin_edit_team_process.php (ОНОВЛЕНО) ---

require_once 'admin_auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Підключення до БД (ОНОВЛЕНО)
    require_once '../db.php';

    // Отримуємо дані з форми
    $team_id = $_POST['team_id'];
    $name = $_POST['name'];
    $role_short = $_POST['role_short'];
    $role_full = $_POST['role_full'];
    $photo_url = $_POST['photo_url'];
    $bio_short = $_POST['bio_short'];
    $bio_full = $_POST['bio_full'];
    
    // Перетворюємо компетенції на JSON
    $competencies_array = explode("\n", trim($_POST['competencies']));
    $competencies = json_encode($competencies_array);

    // Готуємо запит на ОНОВЛЕННЯ
    $stmt = $conn->prepare("UPDATE team SET 
        name = ?, role_short = ?, role_full = ?, photo_url = ?, 
        bio_short = ?, bio_full = ?, competencies = ?
        WHERE id = ?");
    
    $stmt->bind_param("sssssssi", 
        $name, $role_short, $role_full, $photo_url, 
        $bio_short, $bio_full, $competencies, $team_id
    );

    // Виконуємо
    if ($stmt->execute()) {
        header("Location: admin_team.php");
        exit();
    } else {
        echo "Помилка оновлення співробітника: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: admin_team.php");
    exit();
}
?>