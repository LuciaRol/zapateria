<body>
    <main>
        <h2>Lista de productos</h2>
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
                        <th>Precio (€)</th>
                        <th>Stock</th>
                        <th>Oferta</th>
                        <th>Fecha</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr id="producto-<?php echo htmlspecialchars($producto->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                            <td><?php echo htmlspecialchars($producto->getId(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <span class="texto"><?php echo htmlspecialchars($producto->getNombre_categoria(), ENT_QUOTES, 'UTF-8'); ?></span>
                            </td>
                            <td>
                                <span class="texto"><?php echo htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8'); ?></span>
                            </td>
                            <td>
                                <span class="texto"><?php echo htmlspecialchars($producto->getDescripcion() ?? 'Sin descripción', ENT_QUOTES, 'UTF-8'); ?></span>
                            </td>
                            <td>
                                <span class="texto"><?php echo htmlspecialchars($producto->getPrecio(), ENT_QUOTES, 'UTF-8'); ?></span>
                            </td>
                            <td>
                                <span class="texto"><?php echo htmlspecialchars($producto->getStock(), ENT_QUOTES, 'UTF-8'); ?></span>
                            </td>
                            <td>
                                <span class="texto"><?php echo htmlspecialchars($producto->getOferta() ?? 'No', ENT_QUOTES, 'UTF-8'); ?></span>
                            </td>
                            <td>
                                <span class="texto"><?php echo htmlspecialchars($producto->getFecha(), ENT_QUOTES, 'UTF-8'); ?></span>
                            </td>
                            <td>
                                <img class="img_zapato" src="<?php echo htmlspecialchars('public/img/' . ($producto->getImagen() ?? 'placeholder.jpg'), ENT_QUOTES, 'UTF-8'); ?>" alt="Imagen del producto">
                            </td>
                            <td>
                                <!-- Formulario para agregar al carrito -->
                                <form action="<?= BASE_URL ?>agregar_al_carrito" method="POST" style="display:inline;" onsubmit="return verificarStock(this);">
                                    <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="number" name="cantidad" min="1" max="<?php echo htmlspecialchars($producto->getStock(), ENT_QUOTES, 'UTF-8'); ?>" required>
                                    <button type="submit" class="form-submit">Agregar al carrito</button>
                                </form>
                                <?php if ($rol === 'admin'): ?>
                                    <!-- Formulario para eliminar producto -->
                                    <form action="<?= BASE_URL ?>eliminar_producto" method="POST" style="display:inline;">
                                        <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                                        <button type="submit" class="form-submit">Borrar producto</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay productos disponibles.</p>
        <?php endif; ?>
    
        <!-- formulario para agregar nuevos productos -->
        <?php if ($rol === 'admin'): ?>
            <div class="registro-container nuevo">
                <h2 class="registro-form-heading">Crear nuevo producto</h2>
                <div class="registro-form">
                
                <form action="<?= BASE_URL ?>nuevo_producto" method="POST" class="registro-formulario"> 
                    <label for="nuevo_producto">Nombre del Producto:</label><br>
                    <input type="text" id="nuevo_producto" name="nuevo_producto" required class="registro-input"><br><br> 
                    <label for="categoria">Categoría:</label><br>
                    <select id="categoria" name="categoria" required class="registro-select">
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo htmlspecialchars($categoria->getId(), ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($categoria->getNombre(), ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php endforeach; ?>
                    </select><br><br>
                    <label for="descripcion">Descripción:</label><br>
                    <textarea id="descripcion" name="descripcion" rows="4" cols="50" class="registro-textarea"></textarea><br><br>

                    <label for="precio">Precio:</label><br>
                    <input type="number" id="precio" name="precio" step="0.01" required class="registro-input"><br><br>

                    <label for="stock">Stock:</label><br>
                    <input type="number" id="stock" name="stock" required class="registro-input"><br><br>

                    <label for="oferta">Oferta (opcional, máximo 2 caracteres):</label><br>
                    <input type="text" id="oferta" name="oferta" maxlength="2" class="registro-input"><br><br>

                    <label for="fecha">Fecha:</label><br>
                    <input type="date" id="fecha" name="fecha" required class="registro-input"><br><br>

                    <label for="imagen">Imagen:</label><br>
                    <select id="imagen" name="imagen" required class="registro-select">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="zapato<?php echo $i; ?>.jpg">Zapato<?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select><br><br>

                    <input type="submit" value="Crear producto" class="registro-button form-submit"> <!-- Cambiado el texto del botón para reflejar que se está creando un producto -->
                </form>
            </div>
        </div>

        <?php endif; ?>
        <?php if ($rol === 'admin'): ?>
             <h2 class="editar-titulo">Editar productos ya existentes</h2>
        <table class="productos-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Categoría</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio (€)</th>
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
                        <!-- Agregar un formulario para cada fila -->
                        <form action="<?= BASE_URL ?>editar_producto" method="POST">
                            <!-- Utilizar el ID del producto como identificador único -->
                            <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="categoria_id" value="<?php echo htmlspecialchars($producto->getCategoriaId(), ENT_QUOTES, 'UTF-8'); ?>">
                            <td><?php echo htmlspecialchars($producto->getId(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($producto->getNombre_categoria(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><input type="text" name="nombre" value="<?php echo htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8'); ?>"></td>
                            <td><textarea name="descripcion"><?php echo htmlspecialchars($producto->getDescripcion() ?? 'Sin descripción', ENT_QUOTES, 'UTF-8'); ?></textarea></td>
                            <td><input type="number" name="precio" step="0.01" value="<?php echo htmlspecialchars($producto->getPrecio(), ENT_QUOTES, 'UTF-8'); ?>"></td>
                            <td><input type="number" name="stock" value="<?php echo htmlspecialchars($producto->getStock(), ENT_QUOTES, 'UTF-8'); ?>"></td>
                            <td><input type="text" name="oferta" maxlength="2" value="<?php echo htmlspecialchars($producto->getOferta() ?? 'No', ENT_QUOTES, 'UTF-8'); ?>"></td>
                            <td><input type="date" name="fecha" value="<?php echo htmlspecialchars($producto->getFecha(), ENT_QUOTES, 'UTF-8'); ?>"></td>
                            <td>
                                <img class="img_zapato" src="<?php echo htmlspecialchars('public/img/' . ($producto->getImagen() ?? 'placeholder.jpg'), ENT_QUOTES, 'UTF-8'); ?>" alt="Imagen del producto">
                            </td>
                            <td>
                                <button type="submit" class="form-submit">Guardar</button> <!-- No es necesario el formulario en la celda de acciones -->
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
        <?php endif; ?>
            </tbody>
        </table>
    </main>
    <script>
        function verificarStock(form) {
            const cantidad = form.querySelector('input[name="cantidad"]').value;
            const stock = form.querySelector('input[name="cantidad"]').max;
            if (parseInt(cantidad) > parseInt(stock)) {
                alert("La cantidad no puede ser mayor que el stock disponible.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>