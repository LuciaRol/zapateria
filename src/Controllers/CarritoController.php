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
    public function mostrarCarrito($emailRecordado = null)
    {
        // Obtener el email del usuario
        $usuarioController = new UsuarioController();
        $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);

        // Devolver la renderización de la página con los productos en el carrito y el correo electrónico de la sesión
        return $this->pagina->render('mostrarCarrito', ['productosEnCarrito' => $this->productosEnCarrito, 'emailSesion' => $emailSesion]);
    }

    public function agregarAlCarrito($productoId){
        // Obtener el producto de la base de datos utilizando el ID
        $producto = $this->productosService->obtenerProductoPorId($productoId);
    
        // Verificar si se encontró el producto
        if ($producto) {
            // Crear un modelo de carrito con los datos del producto
            $productoEnCarrito = new ProductoEnCarrito(
                $producto['id'],
                $producto['categoria_id'],
                $producto['nombre'],
                $producto['descripcion'],
                $producto['precio'],
                $producto['stock'],
                $producto['oferta'],
                $producto['fecha'],
                $producto['imagen']
            );
    
            // Verificar si ya existe el producto en el carrito
            $productoExistente = null;
            foreach ($this->productosEnCarrito as $productoExistenteEnCarrito) {
                if ($productoExistenteEnCarrito->getId() === $productoEnCarrito->getId()) {
                    $productoExistente = $productoExistenteEnCarrito;
                    break;
                }
            }
    
            // Si el producto ya existe en el carrito, aumentar su cantidad
            if ($productoExistente !== null) {
                $productoExistente->setCantidad($productoExistente->getCantidad() + 1);
            } else {
                // Si el producto no existe en el carrito, agregarlo
                $this->productosEnCarrito[] = $productoEnCarrito;
            }
    
            // Redireccionar a la página del carrito
            $this->mostrarCarrito();
        } else {
            // Si no se encontró el producto, puedes manejar el error de alguna manera (por ejemplo, mostrando un mensaje al usuario)
            echo "El producto no existe";
        }
    }
}