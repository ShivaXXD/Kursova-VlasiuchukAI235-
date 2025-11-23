<?php
// --- service_detail.php (НОВИЙ ФАЙЛ) ---

// 1. Перевіряємо, чи передано ID в URL
if ( !isset($_GET['id']) ) {
    // Якщо ID немає, відправляємо на сторінку всіх послуг
    header("Location: services.php");
    exit();
}

// 2. Підключення до БД (ОНОВЛЕНО)
require_once 'db.php';

// 3. Отримуємо ID (безпечно, як число)
$service_id = intval($_GET['id']);

// 4. Отримуємо ОДНУ послугу з бази за її ID
$stmt = $conn->prepare("SELECT * FROM services WHERE id = ?");
$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // 5. Записуємо всі дані про послугу в змінну $service
    $service = $result->fetch_assoc();
} else {
    // Якщо послуги з таким ID немає
    header("Location: services.php");
    exit();
}

$stmt->close();
$conn->close();

// 6. Розшифровуємо список "Що входить у послугу" (він у базі в JSON)
// Ми робимо trim, щоб видалити випадкові пробіли, і json_decode
$features_list = json_decode(trim($service['page_features']));
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Послуга: <?php echo htmlspecialchars($service['page_title']); ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php" class="logo">Apex Strategies</a>
            <ul>
                <li><a href="index.php">Головна</a></li>
                <li><a href="services.php">Послуги</a></li>
                <li><a href="portfolio.html">Портфоліо</a></li>
                <li><a href="team.php">Наша Команда</a></li>
                <li><a href="contacts.html">Контакти</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1><?php echo htmlspecialchars($service['page_title']); ?></h1>
            
            <div class="service-header">
                <img src="<?php echo htmlspecialchars($service['image_url']); ?>" alt="<?php echo htmlspecialchars($service['page_title']); ?>">
            </div>

            <div class="service-content">
                
                <div class="service-description">
                    <h2><?php echo htmlspecialchars($service['page_subtitle']); ?></h2>
                    <p>
                        <?php echo nl2br(htmlspecialchars($service['page_description'])); ?>
                    </p>
                    
                    <h3>Що входить у послугу:</h3>
                    <ul>
                        <?php
                        // 8. Динамічно генеруємо список "Що входить"
                        if (is_array($features_list)) {
                            foreach ($features_list as $item) {
                                // Використовуємо <strong> для виділення першої частини
                                $parts = explode(':', $item, 2);
                                if (count($parts) > 1) {
                                    echo '<li><strong>' . htmlspecialchars(trim($parts[0])) . ':</strong>' . htmlspecialchars(trim($parts[1])) . '</li>';
                                } else {
                                    echo '<li>' . htmlspecialchars($item) . '</li>';
                                }
                            }
                        }
                        ?>
                    </ul>
                    
                    <br>
                    <a href="payment.html?service=<?php echo urlencode($service['title']); ?>&price=<?php echo $service['price']; ?>" class="btn">
                        Замовити послугу ($<?php echo $service['price']; ?>)
                    </a>
                </div>

                <aside class="service-performer">
                    <h3>Виконує:</h3>
                    
                    <div class="team-member-mini">
                        <img src="<?php echo htmlspecialchars($service['performer_photo_url']); ?>" alt="<?php echo htmlspecialchars($service['performer_name']); ?>">
                        <div>
                            <p><strong><?php echo htmlspecialchars($service['performer_name']); ?></strong></p>
                            <p><span><?php echo htmlspecialchars($service['performer_role']); ?></span></p>
                        </div>
                    </div>
                    <p style="font-size: 0.9rem; color: #555; margin-top: 1rem;">
                        <?php echo nl2br(htmlspecialchars($service['performer_bio'])); ?>
                    </p>
                </aside>

            </div>
        </div>
    </main>
</body>
</html>