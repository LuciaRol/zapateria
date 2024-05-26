<?php
   namespace Routes;

   use Controllers\CategoriasController;
   use Controllers\UsuarioController;
   use Controllers\PedidosController;
   use Controllers\ProductosController;
   use Controllers\CarritoController;
   use Lib\Router;
   use Controllers\ErrorController;

  class Routes{
    public static function index(){
        /*Router::add('GET','/', function (){
            return "Bienvenido";
        });*/
        
        Router::add('GET','/', function () {
            return (new ProductosController())->mostrarProductos();
        });
        Router::add('GET','/categorias', function (){
            return (new CategoriasController())->mostrarTodos();
        });

        Router::add('POST', '/registro_usuario', function () {
            // Verifica si se ha enviado el formulario de registro
            if (isset($_POST['registro'])) {
                // Obtener los datos del formulario
                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
                $email = $_POST['email'];
                $contrasena = $_POST['contrasena'];
                $rol = 'usur'; // El rol por defecto es usuario
                
                // Llamar al controlador y pasar los datos al método registroUsuario
                $usuariosController = new UsuarioController();
                $usuariosController->registroUsuario($nombre, $apellidos, $email, $contrasena, $rol);
            }
        });


        Router::add('POST', '/login', function () {
            // Verificar si se ha enviado el formulario de inicio de sesión
            if (isset($_POST['email']) && isset($_POST['password'])) {
                // Obtener el nombre de usuario y la contraseña del formulario
                $email = $_POST['email'];
                $password = $_POST['password'];
        
                // Crear una instancia del controlador de usuarios
                $usuariosController = new UsuarioController();
                // Llamar al método login del controlador de usuarios con el nombre de usuario y la contraseña
                $usuariosController->login($email, $password);
            }
        });
        
        Router::add('POST','/logout', function (){
            return (new UsuarioController())->logout();
        }); 

        Router::add('GET','/pedidos', function (){
            return (new PedidosController())->mostrarPedidos();
        }); 
        
        Router::add('GET','/usuario', function () {
            return (new UsuarioController())->mostrarUsuario();
        });
        Router::add('GET','/producto', function () {
            return (new ProductosController())->mostrarProductos();
        });

        Router::add('GET','/error', function (){
            /* return (new ErrorController())->show_error404(); */
            return "ERROR";
        });

        Router::add('GET','/registro', function (){
            return (new UsuarioController())->mostrarRegistro();
        });

        Router::add('POST', '/edita_perfil', function () {
            // Check if the form for updating the user profile has been submitted
            if (isset($_POST['new_nombre']) && isset($_POST['new_apellidos']) && isset($_POST['new_rol']) && isset($_POST['new_email'])) {
                // Get the data from the form
                $nombre = $_POST['new_nombre'];
                $apellidos = $_POST['new_apellidos'];
                $email = $_POST['new_email'];
                $rol = $_POST['new_rol'];
                
                // Create an instance of the UsuarioController
                $usuariosController = new UsuarioController();
                // Call the actualizarUsuario method of the UsuarioController with the form data
                $usuariosController->actualizarUsuario($nombre, $apellidos, $email, $rol);
            }
        });
        
        Router::add('POST', '/registro_categoria', function () {
            // Verificar si se ha enviado el formulario para registrar una nueva categoría
            if (isset($_POST['nueva_categoria'])) {
                // Obtener el nombre de la nueva categoría desde el formulario
                $nombreCategoria = $_POST['nueva_categoria'];
                
                // Crear una instancia del controlador de categorías
                $categoriasController = new CategoriasController();
                
                // Llamar al método para registrar una nueva categoría del controlador de categorías
                $categoriasController->registroCategoria($nombreCategoria);
            }
        });

        Router::add('POST', '/agregar_al_carrito', function () {
            // Verificar si se ha enviado el formulario para agregar un producto al carrito
            if (isset($_POST['producto_id'])) {
                // Obtener el ID del producto desde el formulario
                $productoId = $_POST['producto_id'];
                return (new CarritoController())->agregarAlCarrito($productoId);
               
            }
        });
        
        


       /*  Router::add('GET','/Contacto/listar', function (){
            return (new ContactoController())->listar();
        });
        Router::add('GET','/Contacto/registro', function (){
            return (new ContactoController())->registro();
        }); */

        Router::dispatch();
    }
  }