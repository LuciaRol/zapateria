<?php
    namespace Services;
    use Repositories\PedidosRepository;
    use Models\Pedido;
    class PedidosService{
        
        private PedidosRepository $PedidosRepository;
        function __construct() {
            $this->PedidosRepository = new PedidosRepository();
        }

        public function obtenerPedidos($user_id) :?array {
            return $this->PedidosRepository->findPedidos($user_id);
        }
        
        public function guardarPedido(int $usuario_id, string $provincia, string $localidad, string $direccion, float $coste_total, string $fecha_actual, string $hora_actual, string $estado): bool {
            // Crear un nuevo pedido en la base de datos utilizando el repositorio
        
            return $this->PedidosRepository->guardarPedido($usuario_id, $provincia, $localidad, $direccion, $coste_total, $estado, $fecha_actual, $hora_actual);
                                                    
        }

        public function buscarPedidoId(int $usuario_id, string $provincia, string $localidad, string $direccion, string $fecha_actual, string $hora_actual): ?int {
            // Crear un nuevo pedido en la base de datos utilizando el repositorio
        
            return $this->PedidosRepository->buscarPedidoID($usuario_id, $provincia, $localidad, $direccion, $fecha_actual, $hora_actual);
                                                    
        }
        
        public function guardarProductosPedido(int $pedido_id, int $producto_id, int $unidades): bool {
            // Crear un nuevo pedido en la base de datos utilizando el repositorio
        
            return $this->PedidosRepository->guardarProductosPedido($pedido_id, $producto_id, $unidades);
                                                    
        }

        public function nuevoEstado(int $pedido_id, string $nuevo_estado):bool {
        
            return $this->PedidosRepository->nuevoEstado($pedido_id, $nuevo_estado);
                                                    
        }

       
    }
