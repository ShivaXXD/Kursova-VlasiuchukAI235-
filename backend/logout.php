<?php
// --- backend/logout.php ---

// Запускаємо сесію
session_start();

// Знищуємо всі дані сесії
session_unset();
session_destroy();

// Перенаправляємо на головну сторінку сайту
header("Location: ../index.html");
exit();
?>