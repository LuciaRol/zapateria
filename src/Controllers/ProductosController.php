<?php

namespace Controllers;

use Services\ProductosService;
use Lib\Pages;
use Models\Producto;
use Services\UsuariosService;

class ProductosController
{
    private Pages $pagina;
    private ProductosService $productosService;
    private UsuariosService $usuariosService;

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de productos
        $this->productosService = new ProductosService();
        // Crea una instancia del servicio de usuarios
        $this->usuariosService = new UsuariosService();
    }

    public function mostrarProductos($emailRecordado = null)
    {
        // Obtener todos los productos
        $productos = $this->productosService->obtenerProductos();

        // Crear un array para almacenar los objetos de producto
        $productosModel = [];
        foreach ($productos as $producto) {
            // Crear una nueva instancia de Producto con los datos del producto
            $productoModel = new Producto(
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
            // Agregar la instancia de Producto al array
            $productosModel[] = $productoModel;
        }

        // Obtener el email del usuario
        $usuarioController = new UsuarioController();
        $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);

        // Devolver la renderización de la página con los objetos de producto y el correo electrónico de la sesión
        return $this->pagina->render('mostrarProductos', ['productos' => $productosModel, 'emailSesion' => $emailSesion]);
    }
}
