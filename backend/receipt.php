<?php
// === 1. КОНФІГУРАЦІЯ БАЗИ ДАНИХ ===
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apex_strategies_db"; // Переконайся, що назва бази правильна

// === 2. СТВОРЕННЯ З'ЄДНАННЯ ===
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// === 3. ОТРИМАННЯ ID ЗАМОВЛЕННЯ З URL ===
if ( !isset($_GET['order_id']) ) {
    header("Location: ../index.html");
    exit();
}

$order_id = $_GET['order_id'];

// === 4. ОТРИМАННЯ ДАНИХ ЗАМОВЛЕННЯ З БАЗИ (ЗАХИЩЕНО) ===
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id); // 'i' - означає integer
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
} else {
    // Якщо замовлення з таким ID не знайдено
    header("Location: ../index.html");
    exit();
}

$stmt->close();
$conn->close();

// === 5. ГЕНЕРАЦІЯ ДАНИХ ДЛЯ ЧЕКУ ===
$receipt_number = "A-" . str_pad($order['id'], 6, '0', STR_PAD_LEFT);
$order_date = date("d.m.Y \о H:i", strtotime($order['order_time']));
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чек про оплату №<?php echo $receipt_number; ?></title>
    
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

    <header>
        <nav>
            <a href="../index.php" class="logo">Apex Strategies</a>
            <ul>
                <li><a href="../index.php">Головна</a></li>
                <li><a href="../services.php">Послуги</a></li>
                <li><a href="../portfolio.html">Портфоліо</a></li>
                <li><a href="../team.php">Наша Команда</a></li>
                <li><a href="../contacts.html">Контакти</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="receipt-box">
            
            <div class="receipt-header">
                <div class="receipt-icon">✓</div>
                <h2>Оплату успішно проведено!</h2>
                <p>(Це імітація чеку для курсового проекту)</p>
            </div>

            <ul class="receipt-details">
                <li>
                    <span>Номер чеку:</span>
                    <strong><?php echo $receipt_number; ?></strong>
                </li>
                <li>
                    <span>Дата та час:</span>
                    <strong><?php echo $order_date; ?></strong>
                </li>
                <li>
                    <span>Платник:</span>
                    <strong><?php echo htmlspecialchars($order['customer_name']); ?></strong>
                </li>
                <li>
                    <span>Email:</span>
                    <strong><?php echo htmlspecialchars($order['customer_email']); ?></strong>
                </li>
            </ul>

            <hr style="border: none; border-top: 1px dashed #ccc; margin: 1.5rem 0;">

            <ul class="receipt-details">
                <li>
                    <span>Послуга:</span>
                    <strong><?php echo htmlspecialchars($order['service_name']); ?></strong>
                </li>
            </ul>

            <ul class="receipt-details receipt-total">
                <li>
                    <span>РАЗОМ ДО СПЛАТИ:</span>
                    <strong>$<?php echo htmlspecialchars($order['service_price']); ?>.00</strong>
                </li>
            </ul>
            
            <div class="receipt-footer">
                <a href="#" onclick="window.print(); return false;" class="print-btn">
                    Роздрукувати чек
                </a>
                
                <a href="../index.php" class="btn">
                    Повернутися на головну
                </a>
            </div>

        </div>
    </main>

</body>
</html>