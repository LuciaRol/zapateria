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
        
        
        public function guardarProducto(int $categoria_id, string $nombreProducto, string $descripcion, float $precio, int $stock, ?string $oferta, string $fecha, string $imagen): bool {
            return $this->productosRepository->guardarProducto($categoria_id, $nombreProducto, $descripcion, $precio, $stock, $oferta, $fecha, $imagen);
        }
        
        public function obtenerProductoPorId(int $id): ?array {
            return $this->productosRepository->findById($id);
        }

        public function eliminarProducto(int $id): bool {
            return $this->productosRepository->eliminarProducto($id);
        }
    
        public function actualizarStock(int $id, int $nuevoStock): bool {
            return $this->productosRepository->updateStock($id, $nuevoStock);
        }

        public function buscarProductos(string $terminoBusqueda): ?array {
            return $this->productosRepository->buscarProductos($terminoBusqueda);
        }

        
    }