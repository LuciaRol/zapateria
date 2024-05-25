<?php
   namespace Routes;

   use Controllers\CategoriasController;
   use Controllers\ContactoController;
   use Lib\Router;
   use Controllers\ErrorController;

  class Routes{
    public static function index(){
        Router::add('GET','/', function (){
            return "Bienvenido";
        });
        
        Router::add('GET','/categorias', function () {
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
                $categoriasController = new CategoriasController();
                $categoriasController->registroUsuario($nombre, $apellidos, $email, $contrasena, $rol);
            }
        });


        /*Router::add('GET','/', function (){
            return (new CategoriasController())->mostrarTodos();
        });
        /*Router::add('GET','public/', function (){
            return (new ContactoController())->mostrarTodos();
        }); */


        Router::add('GET','/error/', function (){
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