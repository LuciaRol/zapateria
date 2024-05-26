<link rel="stylesheet" href="public/css/styles.css">
<body>
    <main class="container">
        <h2>Perfil de Usuario</h2>
        
        <div class="profile-info">
            <p><strong>Nombre:</strong> <?= htmlspecialchars($nombre) ?></p>
            <p><strong>Apellidos:</strong> <?= htmlspecialchars($apellidos) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
            <p><strong>Rol:</strong> <?= htmlspecialchars($rol) ?></p>
        </div>

        <?php if (isset($error_message)): ?>
            <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>
    </main>
</body>
</html>
