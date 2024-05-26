
<link rel="stylesheet" type="text/css" href="public/css/styles.css">
<body>
    <h2 class="card-h2">Categorías</h2>
    <div class="card-container">
        <?php foreach ($categorias as $categoria): ?>
            <div class="card">
                <div class="card-body">
                    <article class="categoria">
                        <p>ID: <?php echo $categoria->getId(); ?></p>
                        <p>Nombre: <?php echo $categoria->getNombre(); ?></p>
                    </article>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

            

</body>
</html>