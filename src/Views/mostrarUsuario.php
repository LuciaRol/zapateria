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
            <input type="text" id="new_nombre" name="new_nombre" placeholder="Nuevo nombre"  required>
            <br>
            <label for="new_apellidos">Nuevos Apellidos:</label>
            <input type="text" id="new_apellidos" name="new_apellidos" placeholder="Nuevos apellidos"  required>
            <br>
            <!-- Campo oculto para enviar el valor de $email -->
            <input type="hidden" name="new_email" value="<?= htmlspecialchars($email) ?>">
            <?php if ($rol === 'admin'): ?>
                <label for="new_rol">Nuevo Rol:</label>
                <select id="new_rol" name="new_rol">
                    <option value="admin">Admin</option>
                    <option value="usur">Usuario</option>
                </select>
            <?php else: ?>
                <input type="hidden" name="new_rol" value="usur">
            <?php endif; ?>
            <br>
            <input type="submit" value="Guardar Cambios">
        </form>

        <?php if (isset($error_message)): ?>
            <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>
    </main>

    <section>
        <?php if ($rol === 'admin'): ?>
        <div class="row">
            <div class="col-md-12">
                <h3>Listado de Usuarios</h3>
                <table class="table">
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
                                    <form action="<?= BASE_URL ?>edita_perfil" method="POST"> 
                                            <input type="hidden" name="new_nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>">
                                            <input type="hidden" name="new_apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>">
                                            <input type="hidden" name="new_email" value="<?php echo htmlspecialchars($usuario['email']); ?>">
                                            <input type="hidden" name="rol_original" value="<?php echo htmlspecialchars($usuario['rol']); ?>">
                                            <select name="new_rol">
                                                <option value="admin" <?php if ($usuario['rol'] === 'admin') echo 'selected'; ?>>admin</option>
                                                <option value="usur" <?php if ($usuario['rol'] === 'usur') echo 'selected'; ?>>usur</option>
                                            </select>
                                            <input type="submit" value="Guardar">
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
