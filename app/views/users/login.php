<?php include __DIR__ . '/../layouts/header.php'; ?>
<div class="login-container">
    <div class="login-box">
        <h2>Login</h2>

        <?php if (!empty($error)): ?>
            <div class="error-message" style="color: red; margin-bottom: 10px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?controller=User&action=authenticate">
            <label>Email:</label><br>
            <input type="email" name="email" required><br>

            <label>Password:</label><br>
            <input type="password" name="password" required><br>

            <button type="submit">Login</button>
            <a href="index.php?controller=User&action=showActiveProducts" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>