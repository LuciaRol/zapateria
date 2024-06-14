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
        
        public function bajarStockProductos(int $producto_id, int $unidades): bool {
            // Crear un nuevo pedido en la base de datos utilizando el repositorio
        
            return $this->productosRepository->bajarStockProductos($producto_id, $unidades);
                                                    
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

        public function editarProducto(int $productoId, int $categoria_id, string $nombreProducto, string $descripcion, float $precio, int $stock, ?string $oferta, string $fecha): bool {
            return $this->productosRepository->editarProducto($productoId, $categoria_id, $nombreProducto, $descripcion, $precio, $stock, $oferta, $fecha);
        }
        
    }