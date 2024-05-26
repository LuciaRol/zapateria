<?php
    namespace Services;
    use Repositories\productosRepository;
    class productosService{
        
        private productosRepository $productosRepository;
        function __construct() {
            $this->productosRepository = new productosRepository();
        }

        public function obtenerproductos() :?array {
            return $this->productosRepository->findAll();
        }
        
        public function guardarproducto(string $nombreproducto): bool {
            return $this->productosRepository->guardarproducto($nombreproducto);
        }
    }