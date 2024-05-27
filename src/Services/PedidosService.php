<?php
    namespace Services;
    use Repositories\PedidosRepository;
    class PedidosService{
        
        private PedidosRepository $PedidosRepository;
        function __construct() {
            $this->PedidosRepository = new PedidosRepository();
        }

        public function obtenerPedidos() :?array {
            return $this->PedidosRepository->findAll();
        }
        
        public function guardarPedido(int $usuario_id, string $provincia, string $localidad, string $direccion, float $coste_total): bool {
            // Crear un nuevo pedido en la base de datos utilizando el repositorio
            $fecha_actual = date("Y-m-d");
            $hora_actual = date("H:i:s");
            $estado = "Pendiente"; // Estado inicial del pedido
    
            return $this->PedidosRepository->guardarPedido($usuario_id, $provincia, $localidad, $direccion, $coste_total, $estado, $fecha_actual, $hora_actual);
        }
    }
