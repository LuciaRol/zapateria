<!DOCTYPE html>
<html>
<head>
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <main class="user-container">
        <h2 class="user-card-h2">Perfil de Usuario</h2>
        
        <div class="user-card user-profile-info">
            <div class="user-card-body">
                <p><strong>Nombre:</strong> <?= htmlspecialchars($nombre) ?></p>
                <p><strong>Apellidos:</strong> <?= htmlspecialchars($apellidos) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
                <p><strong>Rol:</strong> <?= htmlspecialchars($rol) ?></p>
            </div>
        </div>
        
        <div class="user-card">
            <div class="user-card-body">
                <h3 class="user-card-h2">Editar Perfil</h3>
                <form action="<?= BASE_URL ?>edita_perfil" method="POST" class="user-form">
                    <label for="new_nombre" class="user-form-label">Nuevo Nombre:</label>
                    <input type="text" id="new_nombre" name="new_nombre" placeholder="Nuevo nombre" required class="user-form-input">
                    <br>
                    <label for="new_apellidos" class="user-form-label">Nuevos Apellidos:</label>
                    <input type="text" id="new_apellidos" name="new_apellidos" placeholder="Nuevos apellidos" required class="user-form-input">
                    <br>
                    <input type="hidden" name="new_email" value="<?= htmlspecialchars($email) ?>">
                    <?php if ($rol === 'admin'): ?>
                        <label for="new_rol" class="user-form-label">Nuevo Rol:</label>
                        <select id="new_rol" name="new_rol" class="user-form-input">
                            <option value="admin">Admin</option>
                            <option value="usur">Usuario</option>
                        </select>
                    <?php else: ?>
                        <input type="hidden" name="new_rol" value="usur">
                    <?php endif; ?>
                    <br>
                    <input type="submit" value="Guardar Cambios" class="user-form-submit">
                </form>
            </div>
        </div>

        <?php if (isset($error_message)): ?>
            <p class="user-error-message"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>
    </main>

    <section class="user-container">
        <?php if ($rol === 'admin'): ?>
            <div class="user-card">
                <div class="user-card-body">
                    <h3 class="user-card-h2">Listado de Usuarios</h3>
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Email</th>
                                <th>Nombre de usuario</th>
                                <th>Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['apellidos']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                    <td>
                                        <form action="<?= BASE_URL ?>edita_perfil" method="POST" class="user-form">
                                            <input type="hidden" name="new_nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>">
                                            <input type="hidden" name="new_apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>">
                                            <input type="hidden" name="new_email" value="<?php echo htmlspecialchars($usuario['email']); ?>">
                                            <input type="hidden" name="rol_original" value="<?php echo htmlspecialchars($usuario['rol']); ?>">
                                            <select name="new_rol" class="user-form-input">
                                                <option value="admin" <?php if ($usuario['rol'] === 'admin') echo 'selected'; ?>>admin</option>
                                                <option value="usur" <?php if ($usuario['rol'] === 'usur') echo 'selected'; ?>>usur</option>
                                            </select>
                                            <input type="submit" value="Guardar" class="user-form-submit">
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </section>
</body>
</html>
