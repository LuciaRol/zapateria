<link rel="stylesheet" href="public/css/styles.css">
<header class="header">
    <div class="header_first_div">
        <div class="header_principal">
            <div ><img class="principal_logo" src="public/img/logo.png" alt=""></div>
            <h1 class="principal_title">Zapatería Correcaminos</h1>
        </div>
        <nav class="nav_container">
            <a class="nav_link" href="<?= BASE_URL ?>">Inicio</a>
            <a class="nav_link" href="<?= BASE_URL ?>productos">Productos</a>
            <a class="nav_link" href="<?= BASE_URL ?>pedidos">Pedidos</a>
            <a class="nav_link" href="<?= BASE_URL ?>usuario">Usuario</a>
            <a class="nav_link" href="<?= BASE_URL ?>carrito">Carrito</a>
            <a class="nav_link" href="<?= BASE_URL ?>registro">Registro</a>
        </nav>
    </div>

    <div class="header_second_div">
        <div class="search_container">
            <form action="<?=  BASE_URL ?>busqueda" method="POST">
                <input class="search_input" type="text" name="q" placeholder="Busca">
                <button type="submit" class="search_button login_btn">Buscar</button>
            </form>  
        </div>

        <div class="login_container">
            <?php if (isset($_SESSION['email'])): ?>
                <p>Hola, <?= htmlspecialchars($_SESSION['email']); ?></p>
                <form action="<?= BASE_URL ?>logout" method="POST">
                    <button type="submit" class="logout_button login_btn">Cerrar sesión</button>
                </form>
            <?php else: ?>
                <form action="<?= BASE_URL ?>login" method="POST">
                    <input class="login_user" type="text" name="email" placeholder="Email" required>
                    <input class="login_pass" type="password" name="password" placeholder="Contraseña" required>
                    <button class="login_btn" type="submit">Iniciar sesión</button>
                    <?php if (isset($loginError)): ?>
                        <p><?= htmlspecialchars($loginError); ?></p>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
        </div>
    </div>
</header>




