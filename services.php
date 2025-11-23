<?php
// --- services.php  ---

// 1. Підключення до БД 
require_once 'db.php';

// 2. Отримуємо всі послуги з бази
// Ми беремо тільки ті дані, що потрібні для КАРТОК
$sql_services = "SELECT id, icon, title, description_short, price FROM services ORDER BY id ASC";
$result_services = $conn->query($sql_services);

?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Послуги - Apex Strategies</title>
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
            <h2 style="text-align: center;">Наші Послуги</h2>
            <p style="text-align: center; max-width: 600px; margin: 0 auto 2rem auto;">
                Ми пропонуємо комплексні рішення для вашого бізнесу, 
                розділені за нашими ключовими напрямками експертизи.
            </p>

            <div class="services-grid">
                
                <?php
                if ($result_services->num_rows > 0) {
                    // 3. Проходимо циклом по кожній послузі з бази
                    while($row = $result_services->fetch_assoc()) {
                        
                        // Створюємо картку, підставляючи дані з $row
                        echo '<div class="service-card">';
                        echo '    <div class="icon">' . htmlspecialchars($row["icon"]) . '</div>';
                        echo '    <h3>' . htmlspecialchars($row["title"]) . '</h3>';
                        echo '    <p>' . htmlspecialchars($row["description_short"]) . '</p>';
                        echo '    <p><strong>Ціна: $' . $row["price"] . ' </strong></p>';
                        
                        // 
                        // 4. Посилання тепер веде на ОДИН файл 'service_detail.php'
                        //    і передає йому ID послуги ( ?id=... )
                        //
                        echo '    <a href="service_detail.php?id=' . $row["id"] . '" class="btn">';
                        echo '        Дізнатися більше';
                        echo '    </a>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>Наразі послуг немає. Будь ласка, додайте їх в адмін-панелі.</p>";
                }
                ?>
                
            </div>
        </div>
    </main>

</body>
</html>
<?php
// Закриваємо з'єднання з базою
$conn->close();
?>