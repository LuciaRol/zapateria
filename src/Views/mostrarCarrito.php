<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos en el Carrito</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <main>
        <h2>Productos en el Carrito</h2>
        
        <?php if (!empty($productosEnCarrito)): ?>
            <table class="productos-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Categoría ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Oferta</th>
                        <th>Fecha</th>
                        <th>Imagen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productosEnCarrito as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto->getId(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto->getCategoriaId(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto->getDescripcion() ?? 'Sin descripción', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto->getPrecio(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto->getStock(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto->getOferta() ?? 'No', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto->getFecha(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><img src="<?php echo htmlspecialchars($producto->getImagen() ?? 'placeholder.jpg', ENT_QUOTES, 'UTF-8'); ?>" alt="Imagen del producto"></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay productos en el carrito.</p>
        <?php endif; ?>
    </main>
</body>
</html>
