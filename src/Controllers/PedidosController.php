<?php

namespace Controllers;
use Services\PedidosService;
use Lib\Pages;
use Models\Pedido; 
use Models\Validacion; 
use Services\UsuariosService; 


class PedidosController {

    private Pages $pagina;
    private PedidosService $PedidosService;

    private UsuariosService $usuariosService;

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de categorías
        $this->PedidosService = new PedidosService();

        $this->usuariosService = new UsuariosService();
    }

    public function mostrarPedidos($emailRecordado = null, $userID = null) {
        
        
        $usuarioController = new UsuarioController();
        // Obtener el email del usuario
        $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);

        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            
            // Verifica si el usuario tiene permisos de administrador
            $userID = $email->getId(); }

        
         // Si no hay email de sesión, redirigir a mostrarTodos en CategoriasController
         if (!$emailSesion) {
            $mensaje = "Tienes que registrarte para poder ver los pedidos";
            $productosController = new ProductosController();
            return $productosController->mostrarProductos($emailSesion, $mensaje);
        }
        // Obtener todos los pedidos
        $pedidos = $this->PedidosService->obtenerPedidos($userID);
        // Crear un array para almacenar los objetos de pedido
        $pedidosModel = [];

        foreach ($pedidos as $pedido) {
            // Crear una nueva instancia de Pedido con los datos del pedido
            $pedidoModel = new Pedido();
            $pedidoModel->setId($pedido['id']);
            $pedidoModel->setUsuarioId($pedido['usuario_id']);
            $pedidoModel->setProvincia($pedido['provincia']);
            $pedidoModel->setLocalidad($pedido['localidad']);
            $pedidoModel->setDireccion($pedido['direccion']);
            $pedidoModel->setCoste($pedido['coste']);
            $pedidoModel->setEstado($pedido['estado']);
            $pedidoModel->setFecha($pedido['fecha']);
            $pedidoModel->setHora($pedido['hora']);
            // Agregar la instancia de Pedido al array
            $pedidosModel[] = $pedidoModel;
        }
    
        // Verificar si la sesión está activa y obtener el correo electrónico
        $emailSesion = isset($_SESSION['email']) ? $_SESSION['email'] : null;
    
        // Si no hay sesión activa, utilizar el correo electrónico recordado
        if (!$emailSesion && $emailRecordado) {
            $emailSesion = $emailRecordado;
        }
    
        // Devolver la renderización de la página con los objetos de pedido y el correo electrónico de la sesión
        return $this->pagina->render('mostrarPedidos', ['pedidos' => $pedidosModel, 'emailSesion' => $emailSesion]);
    }
}