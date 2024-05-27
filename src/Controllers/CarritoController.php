<?php

namespace Controllers;

use Services\PedidosService;
use Services\ProductosService;
use Lib\Pages;
use Models\Producto;
use Models\ProductoEnCarrito;
use Services\UsuariosService;
use Services\compraService;

class CarritoController
{
    private Pages $pagina;
    private ProductosService $productosService;
    private UsuariosService $usuariosService;

    private PedidosService $pedidosService;
    private array $productosEnCarrito; // Aquí almacenaremos los productos en el carrito


    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de productos
        $this->productosService = new ProductosService();
        // Crea una instancia del servicio de usuarios
        $this->usuariosService = new UsuariosService();

        $this->pedidosService = new PedidosService();
        
        // Inicializa el array de productos en el carrito
        $this->productosEnCarrito = [];

        
    }

    public function agregarAlCarrito($productoId, $emailRecordado =null)
    {
        // Obtener el producto de la base de datos utilizando el ID
        $producto = $this->productosService->obtenerProductoPorId($productoId);
        // Revisamos que el usuario está registrado
        $usuarioController = new UsuarioController();
        $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);
            // Agregar el producto al carrito
            if ($usuarioController->sesion_usuario()) {

        // Verificar si el producto existe
            if ($producto) {
                // Obtener el email del usuario
                
                    $_SESSION['carrito'][] = $producto;

                    // Guardar el carrito en una variable para pasarla a la vista
                    $productosEnCarrito = $_SESSION['carrito'];

                    
                    // Renderizar la página del carrito con los productos actualizados
                    return $this->mostrarCarrito($emailSesion);                
                }
        } else {
            // Si no se encontró el usuario, vuelve a la página principal
            $mensaje = "Tienes que registrate para poder agregar productos";
            $productosController = new ProductosController();
            return $productosController->mostrarProductos($emailSesion, $mensaje);
 ;
        }
    }
    public function eliminarDelCarrito($key, $emailRecordado = null)
{
    $usuarioController = new UsuarioController();
    if ($usuarioController->sesion_usuario()) {
        $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);
        
        // Verificar si la clave existe en el carrito
        if (isset($_SESSION['carrito'][$key])) {
            // Eliminar el producto del carrito utilizando la clave
            unset($_SESSION['carrito'][$key]);
        }

        // Mostrar el carrito después de eliminar el producto
        return $this->mostrarCarrito($emailSesion);
    }
}

    public function mostrarCarrito($emailSesion = null)
    {
        $usuarioController = new UsuarioController();
        if ($usuarioController->sesion_usuario()) {
            $emailSesion = $usuarioController->obtenerEmailUsuario($emailSesion);
            
            return $this->pagina->render('mostrarCarrito', ['emailSesion' => $emailSesion]);
        }
        else{
            $mensaje = "Tienes que registrarte para poder ver el carrito";
            $productosController = new ProductosController();
            return $productosController->mostrarProductos($emailSesion, $mensaje);
        }
    }

    function comprar($provincia, $localidad,$direccion, $emailSesion = null) {
        $usuarioController = new UsuarioController();
            if ($usuarioController->sesion_usuario()) {
                $emailSesion = $usuarioController->obtenerEmailUsuario($emailSesion);
                // obtener id desde el email
                $usuariosService = new UsuariosService();
            // Verificar si hay elementos en el carrito
                if (!empty($_SESSION['carrito'])) {
                    
                        $usuario = $usuariosService->obtenerUsuarioPorEmail($emailSesion);

                        $usuario_id = $usuario->getId();

                        $coste_total = 0;
                        foreach ($_SESSION['carrito'] as $producto) {
                            $coste_total += $producto['precio'];
                        }
                        
                        $guardar_pedido = $this->pedidosService->guardarPedido($usuario_id, $provincia, $localidad, $direccion, $coste_total);

                        // Vaciar el carrito después de realizar la compra
                        unset($_SESSION['carrito']);
                            
                            // Renderizar la página de mostrarCarrito con el email de sesión
                        return $this-> mostrarCarrito($emailSesion);
                        
                    }
                    else {
                        return $this-> mostrarCarrito($emailSesion);
                        
                        
                }
    }    
}
}