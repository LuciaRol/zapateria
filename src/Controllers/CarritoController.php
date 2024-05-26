<?php

namespace Controllers;

use Services\ProductosService;
use Lib\Pages;
use Models\Producto;
use Models\ProductoEnCarrito;
use Services\UsuariosService;

class CarritoController
{
    private Pages $pagina;
    private ProductosService $productosService;
    private UsuariosService $usuariosService;

    private array $productosEnCarrito; // Aquí almacenaremos los productos en el carrito


    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de productos
        $this->productosService = new ProductosService();
        // Crea una instancia del servicio de usuarios
        $this->usuariosService = new UsuariosService();
        // Inicializa el array de productos en el carrito
        $this->productosEnCarrito = [];

        
    }
    // public function mostrarCarrito($emailRecordado = null, $productosEnCarrito=null)
    // {
    //     // Obtener el email del usuario
    //     $usuarioController = new UsuarioController();
    //     $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);
        

    //     // Devolver la renderización de la página con los productos en el carrito y el correo electrónico de la sesión
    //     return $this->pagina->render('mostrarCarrito', ['productosEnCarrito' => $productosEnCarrito, 'emailSesion' => $emailSesion]);
    // }


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


}