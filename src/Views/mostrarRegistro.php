<link rel="stylesheet" href="public/css/styles.css">
<main>
    <h2 class="sidebar_title">¡Regístrate ahora!</h2>
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
    <form class="registro-form" action="<?= BASE_URL ?>registro_usuario" method="POST">
        <!-- Campos del formulario para el registro de usuario -->
        <input type="text" name="nombre" placeholder="Nombre">
        <input type="text" name="apellidos" placeholder="Apellidos">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="contrasena" placeholder="Contraseña">
        <button type="submit" name="registro">Registrarse</button>
    </form>
</main>
