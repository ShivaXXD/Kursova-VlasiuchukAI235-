<?php
// --- index.php  ---

// 1. Підключаємо наш файл з налаштуваннями бази
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
    <title>Головна - Apex Strategies</title>
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
        <div class="container" style="text-align: center;">
            <h1>Професійний Консалтинг для Вашого Бізнесу</h1>
            <p style="font-size: 1.1rem; margin-bottom: 2rem;">
                Допомагаємо вирішувати складні завдання та досягати нових висот. 
                Цей сайт є курсовим проектом з "Веб-технологій та веб-дизайну".
            </p>
            <a href="services.php" class="btn">Дізнатися про послуги</a>
        </div>

        <section id="team" class="container">
            <h2 style="text-align: center;">Познайомтеся з нашими консультантами</h2>
            
            <div class="team-grid">
                
                <?php
                if ($result_team && $result_team->num_rows > 0) {
                    // 3. Проходимо циклом по кожному члену команди
                    while($member = $result_team->fetch_assoc()) {
                        echo '<div class="team-card">';
                        $photo = !empty($member["photo_url"]) ? htmlspecialchars($member["photo_url"]) : 'assets/default.jpg';
                        
                        echo '    <img src="' . $photo . '" alt="Фото ' . htmlspecialchars($member["name"]) . '">';
                        echo '    <h3>' . htmlspecialchars($member["name"]) . '</h3>';
                        echo '    <p>' . htmlspecialchars($member["role_short"]) . '</p>';
                        echo '    <p class="team-bio">' . htmlspecialchars($member["bio_short"]) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>Співробітників не знайдено або помилка запиту.</p>";
                }
                ?>

            </div>
        </section>

    </main>

</body>
</html>
<?php
// 4. Закриваємо з'єднання з базою
$conn->close();
?>