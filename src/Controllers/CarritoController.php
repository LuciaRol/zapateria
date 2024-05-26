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
    
        // Verificar si el producto existe
        if ($producto) {
            // Obtener el email del usuario
            $usuarioController = new UsuarioController();
            $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);
            // Agregar el producto al carrito
            if ($usuarioController->sesion_usuario()) {

                $_SESSION['carrito'][] = $producto;

                // Guardar el carrito en una variable para pasarla a la vista
                $productosEnCarrito = $_SESSION['carrito'];

                
                // Renderizar la página del carrito con los productos actualizados
                return $this->mostrarCarrito($emailSesion);                
            }
        } else {
            // Si no se encontró el producto, puedes manejar el error de alguna manera (por ejemplo, mostrando un mensaje al usuario)
            echo "El producto no existe";
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
        //  // Obtener el email del usuario
        //  $usuarioController = new UsuarioController();
        //  $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);
         
        return $this->pagina->render('mostrarCarrito', ['emailSesion' => $emailSesion]);
    }



    // public function agregarAlCarrito($productoId){
    
    //     // Obtener el producto de la base de datos utilizando el ID
    // $producto = $this->productosService->obtenerProductoPorId($productoId);

    // // Verificar si se encontró el producto
    // if ($producto) {
    //     // Crear un modelo de carrito con los datos del producto
    //     $productoEnCarrito = new ProductoEnCarrito(
    //         $producto['id'],
    //         $producto['categoria_id'],
    //         $producto['nombre'],
    //         $producto['descripcion'],
    //         $producto['precio'],
    //         $producto['stock'],
    //         $producto['oferta'],
    //         $producto['fecha'],
    //         $producto['imagen']
    //     );

    //     // Agregar el producto al carrito
    //     $this->agregarProductoAlCarrito($productoEnCarrito);

        
    //     // Guardar la instancia de ProductosController en la sesión
        

       
    // } else {
    //     // Si no se encontró el producto, puedes manejar el error de alguna manera (por ejemplo, mostrando un mensaje al usuario)
    //     echo "El producto no existe";

    // }
    // }

    // private function agregarProductoAlCarrito($productoEnCarrito) {
        
    //     array_push($this->productosEnCarrito, $productoEnCarrito);
    //     // Llamar al método para mostrar los productos (asumo que esto renderizará la página de productos con el carrito actualizado)
    //      $this->mostrarCarrito(null,$this->productosEnCarrito);
    // }
}