<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
</head>
<body>
    <h1>Perfil de Usuario</h1>
    
    <p><strong>Nombre:</strong> <?= htmlspecialchars($nombre) ?></p>
    <p><strong>Apellidos:</strong> <?= htmlspecialchars($apellidos) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
    <p><strong>Rol:</strong> <?= htmlspecialchars($rol) ?></p>
    
    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>
</body>
</html>
