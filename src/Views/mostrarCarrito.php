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
        
        <?php if (!empty($_SESSION['carrito'])): ?>
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
                    <?php foreach ($_SESSION['carrito'] as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto['categoria_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto['descripcion'] ?? 'Sin descripción', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto['precio'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto['stock'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto['oferta'] ?? 'No', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto['fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><img src="<?php echo htmlspecialchars($producto['imagen'] ?? 'placeholder.jpg', ENT_QUOTES, 'UTF-8'); ?>" alt="Imagen del producto"></td>
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
