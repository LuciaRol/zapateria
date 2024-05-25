

<!DOCTYPE html>
<html>
<head>
    <title>Mostrar Categorias</title>
    <link rel="stylesheet" type="text/css" href="path/to/your/css/styles.css">
</head>
<body>
    <h1>Categorías</h1>
    <ul>
        <?php foreach ($categorias as $categoria): ?>
            <li>ID: <?php echo $categoria->getId(); ?>, Nombre: <?php echo $categoria->getNombre(); ?></li>
        <?php endforeach; ?>
    </ul>

    <aside class="sidebar">
            <h3 class="sidebar_title">¡Regístrate ahora!</h3>
            <?php
            // Verificar si hay errores de registro y mostrar el mensaje
            if (isset($error_registro) && is_array($error_registro)) {
                echo "<ul>";
                foreach ($error_registro as $error) {
                    echo "<li>$error</li>";
                }
                echo "</ul>";
            }
            ?>
            <form action="<?= BASE_URL ?>registro_usuario" method="POST">
                <!-- Campos del formulario para el registro de usuario -->
                <input type="text" name="nombre" placeholder="Nombre">
                <input type="text" name="apellidos" placeholder="Apellidos">
                <input type="text" name="email" placeholder="Email">
                <input type="password" name="contrasena" placeholder="Contraseña">
                <button type="submit" name="registro">Registrarse</button>
            </form>

</body>
</html>