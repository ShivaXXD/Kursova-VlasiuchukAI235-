<?php
// --- backend/admin_add_service.php ---

// "Охоронець"
require_once 'admin_auth.php';
// Хедер
require_once 'admin_header.php';
?>

<main>
    <div class="admin-container">
        <h1>Додати нову послугу</h1>
        <p>Заповніть всі поля для створення нової послуги на сайті.</p>

        <form action="admin_add_process.php" method="POST" class="payment-form" style="max-width: 1000px;">

            <fieldset style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; margin-bottom: 1.5rem;">
                <legend style="font-size: 1.2rem; font-weight: 600; padding: 0 10px;">
                    1. Вітрина (для `services.html`)
                </legend>
                <div class="form-group">
                    <label>Іконка (напр., 📈):</label>
                    <input type="text" name="icon" required>
                </div>
                <div class="form-group">
                    <label>Назва послуги:</label>
                    <input type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label>Короткий опис (для картки):</label>
                    <input type="text" name="description_short" required>
                </div>
                <div class="form-group">
                    <label>Ціна (тільки цифри, напр., 250):</label>
                    <input type="number" name="price" required>
                </div>
            </fieldset>

            <fieldset style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; margin-bottom: 1.5rem;">
                <legend style="font-size: 1.2rem; font-weight: 600; padding: 0 10px;">
                    2. Детальна сторінка послуги
                </legend>
                <div class="form-group">
                    <label>URL головного зображення:</label>
                    <input type="text" name="image_url" placeholder="https://images.pexels.com/..." required>
                </div>
                <div class="form-group">
                    <label>Заголовок на сторінці (H1):</label>
                    <input type="text" name="page_title" required>
                </div>
                 <div class="form-group">
                    <label>Підзаголовок (H2):</label>
                    <input type="text" name="page_subtitle" required>
                </div>
                <div class="form-group">
                    <label>Повний опис (абзац під H2):</label>
                    <textarea name="page_description" rows="4" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                </div>
                <div class="form-group">
                    <label>
                        Список "Що входить у послугу" (кожен новий пункт з нового рядка):
                    </label>
                    <textarea name="page_features" rows="6" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                </div>
            </fieldset>
            
            <fieldset style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; margin-bottom: 1.5rem;">
                <legend style="font-size: 1.2rem; font-weight: 600; padding: 0 10px;">
                    3. Блок "Виконує"
                </legend>
                <div class="form-group">
                    <label>Ім'я виконавця (напр., Анна Ковальчук):</label>
                    <input type="text" name="performer_name" required>
                </div>
                <div class="form-group">
                    <label>Роль виконавця (напр., Провідний стратег / CEO):</label>
                    <input type="text" name="performer_role" required>
                </div>
                <div class="form-group">
                    <label>URL фото виконавця:</label>
                    <input type="text" name="performer_photo_url" placeholder="https://i.pravatar.cc/..." required>
                </div>
                <div class="form-group">
                    <label>Біографія виконавця (короткий опис):</label>
                    <textarea name="performer_bio" rows="3" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                </div>
            </fieldset>

            <button type="submit" class="btn" style="width: 100%; background: #28a745;">
                Створити послугу
            </button>

        </form>
    </div>
</main>

</body>
</html>