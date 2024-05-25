<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos</title>
    <link rel="stylesheet" href="path/to/your/styles.css">
</head>
<body>
    <header>
        <h1>Lista de Pedidos</h1>
        <?php if (isset($emailSesion)): ?>
            <p>Bienvenido, <?= htmlspecialchars($emailSesion); ?></p>
            <form action="<?= BASE_URL ?>logout" method="POST">
                <button type="submit">Cerrar sesión</button>
            </form>
        <?php endif; ?>
    </header>
    <main>
        <?php if (!empty($pedidos)): ?>
            <table>
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
