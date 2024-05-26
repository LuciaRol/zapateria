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

        public function obtenerProductoPorId(int $id): ?array {
            return $this->productosRepository->findById($id);
        }
    
        public function actualizarStock(int $id, int $nuevoStock): bool {
            return $this->productosRepository->updateStock($id, $nuevoStock);
        }
    }