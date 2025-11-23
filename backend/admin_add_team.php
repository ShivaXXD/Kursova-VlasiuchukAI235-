<?php
// --- backend/admin_add_team.php ---
require_once 'admin_auth.php';
require_once 'admin_header.php';
?>

<main>
    <div class="admin-container">
        <h1>Додати нового співробітника</h1>
        
        <form action="admin_add_team_process.php" method="POST" class="payment-form" style="max-width: 1000px;">

            <fieldset style="border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
                <div class="form-group">
                    <label>Ім'я (напр., Анна Ковальчук):</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>URL фото (напр., https://i.pravatar.cc/150?img=...):</label>
                    <input type="text" name="photo_url" required>
                </div>
                <div class="form-group">
                    <label>Коротка роль (для `index.php`):</label>
                    <input type="text" name="role_short" placeholder="Провідний стратег" required>
                </div>
                <div class="form-group">
                    <label>Повна роль (для `team.php`):</label>
                    <input type="text" name="role_full" placeholder="Провідний стратег / CEO" required>
                </div>
                <div class="form-group">
                    <label>Коротка біографія (для `index.php`):</label>
                    <textarea name="bio_short" rows="3" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                </div>
                <div class="form-group">
                    <label>Повна біографія (для `team.php`):</label>
                    <textarea name="bio_full" rows="5" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                </div>
                <div class="form-group">
                    <label>Компетенції (кожна з нового рядка):</label>
                    <textarea name="competencies" rows="5" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                </div>
            </fieldset>

            <button type="submit" class="btn" style="width: 100%; background: #28a745; margin-top: 1.5rem;">
                Додати співробітника
            </button>

        </form>
    </div>
</main>

</body>
</html>