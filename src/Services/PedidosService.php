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
        
        public function guardarPedido(string $nombrePedido): bool {
            return $this->PedidosRepository->guardarPedido($nombrePedido);
        }
    }