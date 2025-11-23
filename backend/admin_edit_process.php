<?php
// --- backend/admin_edit_process.php (ОНОВЛЕНО) ---

// 1. "Охоронець"
require_once 'admin_auth.php';

// 2. Перевіряємо, чи дані прийшли методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. Підключення до БД (ОНОВЛЕНО)
    require_once '../db.php';

    // 4. Отримуємо ВСІ дані з форми, ВКЛЮЧАЮЧИ ID
    $service_id = $_POST['service_id'];
    
    // Блок 1
    $icon = $_POST['icon'];
    $title = $_POST['title'];
    $description_short = $_POST['description_short'];
    $price = $_POST['price'];

    // Блок 2
    $image_url = $_POST['image_url'];
    $page_title = $_POST['page_title'];
    $page_subtitle = $_POST['page_subtitle'];
    $page_description = $_POST['page_description'];
    
    // Перетворюємо список з textarea на JSON
    $features_array = explode("\n", trim($_POST['page_features']));
    $page_features = json_encode($features_array);

    // Блок 3
    $performer_name = $_POST['performer_name'];
    $performer_role = $_POST['performer_role'];
    $performer_photo_url = $_POST['performer_photo_url'];
    $performer_bio = $_POST['performer_bio'];

    // 5. Готуємо запит на ОНОВЛЕННЯ (UPDATE)
    $stmt = $conn->prepare("UPDATE services SET 
        icon = ?, title = ?, description_short = ?, price = ?, 
        image_url = ?, page_title = ?, page_subtitle = ?, 
        page_description = ?, page_features = ?, performer_name = ?, 
        performer_role = ?, performer_photo_url = ?, performer_bio = ?
        WHERE id = ?");
    
    // 'sssisssssssssi' - 13 рядків/чисел + ID вкінці
    $stmt->bind_param("sssisssssssssi", 
        $icon, $title, $description_short, $price, $image_url, $page_title, $page_subtitle, 
        $page_description, $page_features, $performer_name, $performer_role, 
        $performer_photo_url, $performer_bio,
        $service_id  // ID йде останнім, бо відповідає 'WHERE id = ?'
    );

    // 6. Виконуємо і перенаправляємо
    if ($stmt->execute()) {
        header("Location: admin_services.php");
        exit();
    } else {
        echo "Помилка оновлення послуги: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: admin_services.php");
    exit();
}
?>