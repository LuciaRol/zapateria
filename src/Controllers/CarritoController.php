<?php

namespace Controllers;

use Services\PedidosService;
use Services\ProductosService;
use Lib\Pages;
use Services\UsuariosService;
use Controllers\MailController;


class CarritoController
{
    private Pages $pagina;
    private ProductosService $productosService;
    private UsuariosService $usuariosService;

    private PedidosService $pedidosService;
    private array $productosEnCarrito; // Aquí almacenaremos los productos en el carrito

    private MailController $MailController;



    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de productos
        $this->productosService = new ProductosService();
        // Crea una instancia del servicio de usuarios
        $this->usuariosService = new UsuariosService();

        $this->pedidosService = new PedidosService();

        $this->MailController = new MailController();

        
        // Inicializa el array de productos en el carrito
        $this->productosEnCarrito = [];

        
    }

    public function agregarAlCarrito($productoId, $cantidad, $emailRecordado = null): void
    {
        // Obtener el producto de la base de datos utilizando el ID
        $producto = $this->productosService->obtenerProductoPorId($productoId);

        // Revisamos que el usuario está registrado
        $usuarioController = new UsuarioController();
        $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);

        // Verificar si el usuario está en sesión
        if ($usuarioController->sesion_usuario()) {
            // Verificar si el producto existe
            if ($producto) {
                // Comprobar si el carrito ya tiene productos
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = [];
                }

                // Verificar si el producto ya está en el carrito
                $productoEncontrado = false;
                foreach ($_SESSION['carrito'] as &$item) {
                    if ($item['producto']['id'] == $productoId) {
                        // Si el producto ya está en el carrito, simplemente incrementa la cantidad
                        $item['cantidad'] += $cantidad;
                        $productoEncontrado = true;
                        break;
                    }
                }

                // Si el producto no está en el carrito, agregarlo con la cantidad especificada
                if (!$productoEncontrado) {
                    $_SESSION['carrito'][] = [
                        'producto' => $producto,
                        'cantidad' => $cantidad
                    ];
                }

                // Guardar el carrito en una variable para pasarla a la vista
                $productosEnCarrito = $_SESSION['carrito'];

                // Renderizar la página del carrito con los productos actualizados
                $this->mostrarCarrito($emailSesion);
            }
        } else {
            // Si no se encontró el usuario, vuelve a la página principal
            $mensaje = "Tienes que registrarte para poder agregar productos";
            $productosController = new ProductosController();
            $productosController->mostrarProductos($emailSesion, $mensaje);
        }
    }

    public function eliminarDelCarrito($key, $emailRecordado = null):  void
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
            $this->mostrarCarrito($emailSesion);
        }
    }

    public function mostrarCarrito($emailSesion = null): void
    {
        $usuarioController = new UsuarioController();
        if ($usuarioController->sesion_usuario()) {
            $emailSesion = $usuarioController->obtenerEmailUsuario($emailSesion);
            
            $this->pagina->render('mostrarCarrito', ['emailSesion' => $emailSesion]);
        }
        else{
            $mensaje = "Tienes que registrarte para poder ver el carrito";
            $categoriasController = new CategoriasController();
            $categoriasController->mostrarTodos($emailSesion, $mensaje);
        }
    }

    public function comprar($provincia, $localidad, $direccion, $emailSesion = null): void {
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
                foreach ($_SESSION['carrito'] as $item) {
                    $coste_total += $item['producto']['precio'] * $item['cantidad'];
                }
                
                $fecha_actual = date("Y-m-d");
                $hora_actual = date("H:i:s");
                $estado = "No enviado"; // Estado inicial del pedido
    
                $guardar_pedido = $this->pedidosService->guardarPedido($usuario_id, $provincia, $localidad, $direccion, $coste_total, $fecha_actual, $hora_actual, $estado);
    
                // Obtener el ID del pedido recién guardado
                $pedido_id = $this->pedidosService->buscarPedidoId($usuario_id, $provincia, $localidad, $direccion, $fecha_actual, $hora_actual);
    
                // Guardar los productos en la base de datos
                foreach ($_SESSION['carrito'] as $item) {
                    $producto_id = $item['producto']['id'];
                    $cantidad = $item['cantidad'];
                    $guardar_productos_pedido = $this->pedidosService->guardarProductosPedido($pedido_id, $producto_id, $cantidad);
                    $bajar_stock_productos = $this->productosService->bajarStockProductos($producto_id, $cantidad);
                }
    
                // Crear el array de productos para el correo
                $productos = array();
                foreach ($_SESSION['carrito'] as $item) {
                    $productos[] = array(
                        'nombre' => $item['producto']['nombre'],
                        'cantidad' => $item['cantidad'],
                        'precio' => $item['producto']['precio']
                    );
                }
    
                // Enviar el correo
                $MailController = new MailController();
                $MailController->mailcompra($pedido_id, $emailSesion, $direccion, $provincia, $localidad, $coste_total, $productos);
    
                // Vaciar el carrito después de realizar la compra
                unset($_SESSION['carrito']);
    
                // Renderizar la página de mostrarCarrito con el email de sesión
                $this->mostrarCarrito($emailSesion);
                
            } else {
                $this->mostrarCarrito($emailSesion);
            }
        }
    }
    


}