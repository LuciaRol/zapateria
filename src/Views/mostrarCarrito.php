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
                        <th>Cantidad</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($_SESSION['carrito'] as $key => $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['producto']['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['producto']['categoria_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['producto']['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['producto']['descripcion'] ?? 'Sin descripción', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['producto']['precio'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['producto']['stock'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['producto']['oferta'] ?? 'No', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['producto']['fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <img class="img_zapato" src="<?php echo htmlspecialchars('public/img/' . ($item['producto']['imagen'] ?? 'placeholder.jpg'), ENT_QUOTES, 'UTF-8'); ?>" alt="Imagen del producto">
                        </td>
                        <td><?php echo htmlspecialchars($item['cantidad'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td> 
                            <form method="POST" action="<?= BASE_URL ?>eliminar_producto_carrito">
                                <input type="hidden" name="producto_id" value="<?php echo $item['producto']['id']; ?>">
                                <input type="hidden" name="producto_key" value="<?php echo $key; ?>"> <!-- Aquí añadimos la clave del producto -->
                                <button type="submit" class="eliminar-btn form-submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <form method="POST" action="<?= BASE_URL ?>comprar_carrito" class="purchase-form">
                <label for="provincia" class="purchase-form-label">Provincia:</label>
                <input type="text" id="provincia" name="provincia" required class="purchase-form-input"><br>
                <label for="localidad" class="purchase-form-label">Localidad:</label>
                <input type="text" id="localidad" name="localidad" required class="purchase-form-input"><br>
                <label for="direccion" class="purchase-form-label">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required class="purchase-form-input"><br>
                <button type="submit" class="form-submit">Comprar</button>
            </form>
        <?php else: ?>
            <p>No hay productos en el carrito.</p>
        <?php endif; ?>
    </main>
</body>
</html>
