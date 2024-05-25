
<header class="header">
    <div class="header_first_div">
        <div class="header_principal">
            <div ><img class="principal_logo" src="Assets/img/nebulosa.png" alt=""></div>
            <h1 class="principal_title">Blog</h1>
        </div>
        <nav class="nav_container">
            <a class="nav_link" href="<?= BASE_URL ?>?controller=Blog&action=mostrarblogsesion">Inicio</a>
            <a class="nav_link" href="<?= BASE_URL ?>?controller=Usuario&action=mostrarUsuario">Info Usuario</a>
            <a class="nav_link" href="<?= BASE_URL ?>?controller=Categoria&action=mostrarCategorias">Categorías</a>
            <a class="nav_link" href="<?= BASE_URL ?>?controller=Entrada&action=mostrarEntradas">Entradas</a>
            <a class="nav_link" href="">Contacto</a>
        </nav>
    </div>

    <div class="header_second_div">
        <div class="search_container">
            <form action="<?= BASE_URL ?>?controller=Blog&action=buscar" method="POST">
                <label class="search_label" for="buscar">Buscar</label>
                <input class="search_input" type="text" name="q" placeholder="Busca">
                <button type="submit" class="search_button">Buscar</button>
            </form>
            
        </div>

        <div class="login_container">
            <?php if (isset($_SESSION['email'])): ?>
                <p>Hola, <?= htmlspecialchars($_SESSION['email']); ?></p>
                <form action="<?= BASE_URL ?>logout" method="POST">
                    <button type="submit" class="logout_button">Cerrar sesión</button>
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




