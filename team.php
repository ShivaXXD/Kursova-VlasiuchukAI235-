<?php
// --- team.php (ОНОВЛЕНО) ---

// 1. Підключення до БД (ОНОВЛЕНО)
require_once 'db.php';

// 2. Отримуємо ВСІХ членів команди з бази
$sql_team = "SELECT * FROM team ORDER BY id ASC";
$result_team = $conn->query($sql_team);

?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Наша Команда - Apex Strategies</title>
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
            <h1 style="text-align: center;">Познайомтеся з нашими експертами</h1>
            <p style="text-align: center; max-width: 700px; margin: 0 auto 3rem auto;">
                Наша сила – у команді. Кожен з наших консультантів є
                визнаним фахівцем у своїй галузі, готовим 
                застосувати свій досвід для вашого успіху.
            </p>

            <?php
            if ($result_team->num_rows > 0) {
                // 3. Проходимо циклом по кожному
                while($member = $result_team->fetch_assoc()) {
                    
                    // 4. Розкодовуємо список компетенцій
                    $competencies_list = json_decode($member['competencies']);
                    
                    // "Малюємо" HTML-картку для кожного
                    echo '<div class="team-detailed-card">';
                    echo '    <img src="' . htmlspecialchars($member["photo_url"]) . '" alt="Фото ' . htmlspecialchars($member["name"]) . '">';
                    echo '    <div class="team-detailed-info">';
                    echo '        <h2>' . htmlspecialchars($member["name"]) . '</h2>';
                    echo '        <p class="role">' . htmlspecialchars($member["role_full"]) . '</p>';
                    echo '        <p>' . htmlspecialchars($member["bio_full"]) . '</p>';
                    echo '        <h3>Основні компетенції:</h3>';
                    echo '        <ul>';
                    
                    // 5. Внутрішній цикл для списку компетенцій
                    if (is_array($competencies_list)) {
                        foreach ($competencies_list as $item) {
                            echo '<li>' . htmlspecialchars($item) . '</li>';
                        }
                    }
                    
                    echo '        </ul>';
                    echo '    </div>';
                    echo '</div>';
                }
            } else {
                echo "<p>Співробітників не знайдено.</p>";
            }
            ?>
            
        </div>
    </main>

</body>
</html>
<?php
// 6. Закриваємо з'єднання з базою
$conn->close();
?>