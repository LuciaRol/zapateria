<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <main>
        <h2>Lista de Productos</h2>
        <?php if (!empty($mensaje)): ?>
            <p class="mensaje"><?php echo $mensaje; ?></p>
        <?php endif; ?>
        <?php if (!empty($productos)): ?>
            <table class="productos-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Categoría</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Oferta</th>
                        <th>Fecha</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto->getId(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto->getNombre_categoria(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto->getDescripcion() ?? 'Sin descripción', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto->getPrecio(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto->getStock(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto->getOferta() ?? 'No', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto->getFecha(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><img src="<?php echo htmlspecialchars($producto->getImagen() ?? 'placeholder.jpg', ENT_QUOTES, 'UTF-8'); ?>" alt="Imagen del producto"></td>
                            <td>
                                <!-- Formulario para agregar al carrito -->
                                <form action="<?= BASE_URL ?>agregar_al_carrito" method="POST">
                                    <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit">Agregar al carrito</button>
                                </form>
                                <!-- Formulario para agregar al carrito -->
                                <form action="<?= BASE_URL ?>borrar_producto" method="POST">
                                    <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit">Borrar Producto</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay productos disponibles.</p>
        <?php endif; ?>
    
        <div class="card">
        <div class="card-body">
            <h2 class="card-h2">Crear Nuevo Producto</h2>
            <form action="<?= BASE_URL ?>nuevo_producto" method="POST"> 
                <label for="nuevo_producto">Nombre del Producto:</label><br>
                <input type="text" id="nuevo_producto" name="nuevo_producto" required><br><br> 
                <label for="categoria">Categoría:</label><br>
                <select id="categoria" name="categoria" required>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo htmlspecialchars($categoria->getId(), ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($categoria->getNombre(), ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select><br><br>
                <label for="descripcion">Descripción:</label><br>
                <textarea id="descripcion" name="descripcion" rows="4" cols="50"></textarea><br><br>

                <label for="precio">Precio:</label><br>
                <input type="float" id="precio" name="precio" step="0.01" required><br><br>

                <label for="stock">Stock:</label><br>
                <input type="float" id="stock" name="stock" required><br><br>

                <label for="oferta">Oferta (opcional, máximo 2 caracteres):</label><br>
                <input type="text" id="oferta" name="oferta" maxlength="2"><br><br>

                <label for="fecha">Fecha:</label><br>
                <input type="date" id="fecha" name="fecha" required><br><br>

                <input type="submit" value="Crear Producto"> <!-- Cambiado el texto del botón para reflejar que se está creando un producto -->
            </form>
        </div>
    </div>
    </main>
</body>
</html>
