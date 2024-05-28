<?php

namespace Controllers;

use Services\ProductosService;
use Lib\Pages;
use Models\Producto;
use Models\ProductoEnCarrito;
use Services\UsuariosService;
use Models\Validacion;
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

    public function mostrarProductos($emailRecordado = null, $mensaje = null)
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
                $producto['categoria'],
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
        // Verifica si el usuario está autenticado
        $rol = 'usur';
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            // Verifica si el usuario tiene permisos de administrador
            $rol = $email->getRol();
            }

        $categoriasController = new CategoriasController();
        $categorias = $categoriasController->todasCategorias();
        // Devolver la renderización de la página con los objetos de producto y el correo electrónico de la sesión
        return $this->pagina->render('mostrarProductos', ['productos' => $productosModel, 'emailSesion' => $emailSesion, 'rol' => $rol, 'mensaje' => $mensaje, 'categorias' => $categorias]);
    }

    public function registroProducto($categoria_id, $nombreProducto, $descripcion, $precio, $stock, $oferta, $fecha) {
        $mensaje = 'Regístrate como admin para crear un producto'; // Inicializamos la variable de mensaje
        
        $usuarioController = new UsuarioController();
        // Verifica si el usuario está autenticado
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            
            // Verifica si el usuario tiene permisos de administrador
            if ($email->getRol() === 'admin') {
                // Sanea los datos del producto
                $nombreProducto = Validacion::sanearString($nombreProducto);
                $descripcion = Validacion::sanearString($descripcion);
                $precio = Validacion::sanearNumero($precio);
                $stock = Validacion::sanearNumero($stock);
                $oferta = Validacion::sanearString($oferta);
    
                // Validar campos obligatorios
                if (empty($nombreProducto) || empty($categoria_id) || empty($precio) || empty($stock) || empty($fecha)) {
                    $mensaje = "Debe proporcionar todos los campos obligatorios.";
                } else {
                    // Guardar el nuevo producto
                    $imagen = "";
                    $this->productosService->guardarProducto($categoria_id, $nombreProducto, $descripcion, $precio, $stock, $oferta, $fecha, $imagen);
                    $mensaje = "Producto creado exitosamente.";
                }
            } else {
                // Si el usuario no es administrador, asigna un mensaje indicando que no tiene permisos suficientes
                $mensaje = "No tienes permisos de administrador para registrar nuevos productos.";
            }
        }
    
        $this->mostrarProductos($email, $mensaje);
    }
   
public function eliminarProducto($producto_id, $emailRecordado = null)
    {   
        $mensaje = 'Tienes que ser admin para borrar un producto'; // Inicializamos la variable de mensaje

        $usuarioController = new UsuarioController();
        if ($usuarioController->sesion_usuario()) {
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            
            // Verifica si el usuario tiene permisos de administrador
            if ($email->getRol() === 'admin') {
                $this->productosService->eliminarProducto($producto_id);
                $mensaje = "Producto borrado exitosamente.";


                // Mostrar el carrito después de eliminar el producto
                return $this->mostrarProductos($email, $mensaje);
            }
            else {
                return $this->mostrarProductos(null, $mensaje);
            }
        }
        else {
            return $this->mostrarProductos(null, $mensaje);

        }
    }

}