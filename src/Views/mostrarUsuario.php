<!DOCTYPE html>
<html>
<head>
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <main class="container">
        <h2>Perfil de Usuario</h2>
        
        <div class="profile-info">
            <p><strong>Nombre:</strong> <?= htmlspecialchars($nombre) ?></p>
            <p><strong>Apellidos:</strong> <?= htmlspecialchars($apellidos) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
            <p><strong>Rol:</strong> <?= htmlspecialchars($rol) ?></p>
        </div>
        
        <form action="<?= BASE_URL ?>edita_perfil" method="POST"> 
            <h3>Editar Perfil</h3>
            <label for="new_nombre">Nuevo Nombre:</label>
            <input type="text" id="new_nombre" name="new_nombre" placeholder="Nuevo nombre">
            <br>
            <label for="new_apellidos">Nuevos Apellidos:</label>
            <input type="text" id="new_apellidos" name="new_apellidos" placeholder="Nuevos apellidos">
            <br>
            <!-- Campo oculto para enviar el valor de $email -->
            <input type="hidden" name="new_email" value="<?= htmlspecialchars($email) ?>">
            <label for="new_rol">Nuevo Rol:</label>
            <select id="new_rol" name="new_rol">
                <option value="admin">Admin</option>
                <option value="usur">Usuario</option>
            </select>
            <br>
            <input type="submit" value="Guardar Cambios">
        </form>

        <?php if (isset($error_message)): ?>
            <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>
    </main>
</body>
</html>
