<?php
    namespace Services;
    use Repositories\categoriasRepository;
    class CategoriasService{
        
        private CategoriasRepository $categoriasRepository;
        function __construct() {
            $this->categoriasRepository = new CategoriasRepository();
        }

        public function obtenercategorias() :?array {
            return $this->categoriasRepository->findAll();
        }
        
        public function guardarCategoria(string $nombreCategoria, string $imagen): bool {
            return $this->categoriasRepository->guardarCategoria($nombreCategoria, $imagen);
        }
    }