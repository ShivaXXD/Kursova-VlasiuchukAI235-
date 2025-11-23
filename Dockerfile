# Використовуємо офіційний образ PHP з Apache
FROM php:8.2-apache

# --- Встановлюємо розширення mysqli та pdo для роботи з базою ---
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli

# Копіюємо всі файли проєкту в папку сервера
COPY . /var/www/html/

# Відкриваємо порт 80
EXPOSE 80