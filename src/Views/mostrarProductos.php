<link rel="stylesheet" href="public/css/styles.css">
<body>
    <main>
        <h2>Lista de Productos</h2>
        
        <?php if (!empty($productos)): ?>
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
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo $producto->getId(); ?></td>
                            <td><?php echo $producto->getCategoriaId(); ?></td>
                            <td><?php echo $producto->getNombre(); ?></td>
                            <td><?php echo $producto->getDescripcion() ?? 'Sin descripción'; ?></td>
                            <td><?php echo $producto->getPrecio(); ?></td>
                            <td><?php echo $producto->getStock(); ?></td>
                            <td><?php echo $producto->getOferta() ?? 'No'; ?></td>
                            <td><?php echo $producto->getFecha(); ?></td>
                            <td><img src="<?php echo $producto->getImagen() ?? 'placeholder.jpg'; ?>" alt="Imagen del producto"></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay productos disponibles.</p>
        <?php endif; ?>
    </main>
</body>
</html>
