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
</body>
</html>