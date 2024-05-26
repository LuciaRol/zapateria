<?php
   namespace Routes;

   use Controllers\CategoriasController;
   use Controllers\UsuarioController;
   use Controllers\PedidosController;
   use Controllers\ProductosController;
   use Lib\Router;
   use Controllers\ErrorController;

  class Routes{
    public static function index(){
        /*Router::add('GET','/', function (){
            return "Bienvenido";
        });*/
        
        Router::add('GET','/', function () {
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



       /*  Router::add('GET','/Contacto/listar', function (){
            return (new ContactoController())->listar();
        });
        Router::add('GET','/Contacto/registro', function (){
            return (new ContactoController())->registro();
        }); */

        Router::dispatch();
    }
  }