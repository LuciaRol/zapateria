
<link rel="stylesheet" href="public/css/styles.css">
<body>
    <main>
        <h2 class="pedido-table-h2">Lista de Pedidos</h2>
        
        <?php if (!empty($pedidos)): ?>
            <table class="pedido-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario ID</th>
                        <th>Provincia</th>
                        <th>Localidad</th>
                        <th>Dirección</th>
                        <th>Coste</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?= htmlspecialchars($pedido->getId()); ?></td>
                            <td><?= htmlspecialchars($pedido->getUsuarioId()); ?></td>
                            <td><?= htmlspecialchars($pedido->getProvincia()); ?></td>
                            <td><?= htmlspecialchars($pedido->getLocalidad()); ?></td>
                            <td><?= htmlspecialchars($pedido->getDireccion()); ?></td>
                            <td><?= htmlspecialchars($pedido->getCoste()); ?></td>
                            <td><?= htmlspecialchars($pedido->getEstado()); ?></td>
                            <td><?= htmlspecialchars($pedido->getFecha()); ?></td>
                            <td><?= htmlspecialchars($pedido->getHora()); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay pedidos disponibles.</p>
        <?php endif; ?>
    </main>
</body>
</html>
