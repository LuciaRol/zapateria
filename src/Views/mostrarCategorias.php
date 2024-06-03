<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorías</title>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css">
</head>
<body>
    <h2 class="card-h2">Categorías</h2>
    <div class="card-container">
    <?php if (!empty($mensaje)): ?>
            <p class="mensaje"><?php echo $mensaje; ?></p>
    <?php endif; ?>
        <?php foreach ($categorias as $categoria): ?>
            <div class="card">
                <div class="card-body">
                    <article class="categoria">
                        <p>ID: <?php echo $categoria->getId(); ?></p>
                        <p>Nombre: <?php echo $categoria->getNombre(); ?></p>
                        <!-- Formulario para mostrar productos de esta categoría -->
                        <form action="<?= BASE_URL ?>busqueda" method="POST">
                            <input type="hidden" name="q" value="<?php echo $categoria->getNombre(); ?>">
                            <input type="submit" value="Mostrar productos de categoría">
                        </form>
                    </article>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Formulario para crear una nueva categoría -->
    <?php if ($rol === 'admin'): ?>
    <div class="card">
        <div class="card-body">
            <h2 class="card-h2">Crear Nueva Categoría</h2>
            <form action="<?= BASE_URL ?>registro_categoria" method="POST"> 
                <label for="nueva_categoria">Nombre:</label>
                <input type="text" id="nueva_categoria" name="nueva_categoria" required><br><br>
                <input type="submit" value="Crear Categoría">
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Display message if it exists -->
    <?php if (!empty($mensaje)): ?>
        <div class="message">
            <p><?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    <?php endif; ?>

</body>
</html>
