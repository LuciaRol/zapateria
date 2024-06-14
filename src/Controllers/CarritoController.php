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

    public function agregarAlCarrito($productoId, $emailRecordado =null): void
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
                    $this->mostrarCarrito($emailSesion);                
                }
        } else {
            // Si no se encontró el usuario, vuelve a la página principal
            $mensaje = "Tienes que registrate para poder agregar productos";
            $productosController = new ProductosController();
            $productosController->mostrarProductos($emailSesion, $mensaje);
 ;
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

    function comprar($provincia, $localidad,$direccion, $emailSesion = null): void {
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
                        
                        $fecha_actual = date("Y-m-d");
                        $hora_actual = date("H:i:s");
                        $estado = "No enviado"; // Estado inicial del pedido

                        $guardar_pedido = $this->pedidosService->guardarPedido($usuario_id, $provincia, $localidad, $direccion, $coste_total, $fecha_actual, $hora_actual, $estado);

                       
                        // Aquí guardamos los productos del pedido
                        $pedido_id = $this->pedidosService->buscarPedidoId($usuario_id, $provincia, $localidad, $direccion, $fecha_actual, $hora_actual);

                       // Array para contar la cantidad de productos por id
                        $cantidad_productos = array();

                        // Recorre todos los productos en el carrito
                        foreach ($_SESSION['carrito'] as $producto) {
                            $producto_id = $producto['id'];

                            // Verifica si ya hemos encontrado este producto
                            if (array_key_exists($producto_id, $cantidad_productos)) {
                                // Si ya existe, incrementa la cantidad
                                $cantidad_productos[$producto_id]++;
                            } else {
                                // Si no existe, inicializa la cantidad en 1
                                $cantidad_productos[$producto_id] = 1;
                            }
                        }
                        // Ahora, guardamos los productos en la base de datos
                        foreach ($cantidad_productos as $producto_id => $unidades) {
                            $guardar_productos_pedido = $this->pedidosService->guardarProductosPedido($pedido_id, $producto_id, $unidades);
                            $bajar_stock_productos = $this->productosService->bajarStockProductos($producto_id, $unidades);
                        }

                        // Crear el array de productos para el correo
                        $productos = array();
                        foreach ($_SESSION['carrito'] as $producto) {
                            $productos[] = array(
                                'nombre' => $producto['nombre'],
                                'cantidad' => $cantidad_productos[$producto['id']],
                                'precio' => $producto['precio']
                            );
                        }

                        // Enviar el correo
                        $MailController = new MailController();
                        $MailController->mailcompra($pedido_id, $emailSesion, $direccion, $provincia, $localidad, $coste_total, $productos);


                        // Vaciar el carrito después de realizar la compra
                         unset($_SESSION['carrito']);
                        

                            // Renderizar la página de mostrarCarrito con el email de sesión
                        $this-> mostrarCarrito($emailSesion);
                        
                    }
                    else {
                        $this-> mostrarCarrito($emailSesion);
                    }
    }    
}


}