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
            <form action="<?= BASE_URL ?>?controller=Blog&action=registroUsuario" method="POST">
            <div class="sidebar_inputs">
           
                <input type="text" class="sidebar_input" placeholder="Nombre" name="nombre">
                <input type="text" class="sidebar_input" placeholder="Apellidos" name="apellidos">
                <input type="email" class="sidebar_input" placeholder="Email" name="email">
                <input type="username" class="sidebar_input" placeholder="Username" name="username">
                <input type="password" class="sidebar_input" placeholder="Contraseña" name="contrasena">
                <button type="submit" class="sidebar_btn" name="registro">Registrarse</button>

           
            </div>
            </form>
        </aside>       
</body>
</html>