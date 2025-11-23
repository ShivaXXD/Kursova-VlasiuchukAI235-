<?php
// --- backend/admin_add_team_process.php ---

require_once 'admin_auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Підключення до БД (ОНОВЛЕНО)
    require_once 'db.php';

    // Отримуємо дані з форми
    $name = $_POST['name'];
    $role_short = $_POST['role_short'];
    $role_full = $_POST['role_full'];
    $photo_url = $_POST['photo_url'];
    $bio_short = $_POST['bio_short'];
    $bio_full = $_POST['bio_full'];
    
    // Перетворюємо список компетенцій на JSON
    $competencies_array = explode("\n", trim($_POST['competencies']));
    $competencies = json_encode($competencies_array);

    // Готуємо запит
    $stmt = $conn->prepare("INSERT INTO team (name, role_short, role_full, photo_url, bio_short, bio_full, competencies) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $role_short, $role_full, $photo_url, $bio_short, $bio_full, $competencies);

    // Виконуємо
    if ($stmt->execute()) {
        header("Location: admin_team.php");
        exit();
    } else {
        echo "Помилка додавання співробітника: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: admin_team.php");
    exit();
}
?>