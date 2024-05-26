<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
</head>
<body>
    <h1>Lista de Productos</h1>
    <?php if (!empty($productos)): ?>
        <ul>
            <?php foreach ($productos as $producto): ?>
                <li>
                    <strong>ID:</strong> <?php echo $producto->getId(); ?><br>
                    <strong>Categoría ID:</strong> <?php echo $producto->getCategoriaId(); ?><br>
                    <strong>Nombre:</strong> <?php echo $producto->getNombre(); ?><br>
                    <strong>Descripción:</strong> <?php echo $producto->getDescripcion() ?? 'Sin descripción'; ?><br>
                    <strong>Precio:</strong> <?php echo $producto->getPrecio(); ?><br>
                    <strong>Stock:</strong> <?php echo $producto->getStock(); ?><br>
                    <strong>Oferta:</strong> <?php echo $producto->getOferta() ?? 'No'; ?><br>
                    <strong>Fecha:</strong> <?php echo $producto->getFecha(); ?><br>
                    <strong>Imagen:</strong> <img src="<?php echo $producto->getImagen() ?? 'placeholder.jpg'; ?>" alt="Imagen del producto"><br>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay productos disponibles.</p>
    <?php endif; ?>
</body>
</html>
