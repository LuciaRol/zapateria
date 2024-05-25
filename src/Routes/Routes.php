<?php
   namespace Routes;

   use Controllers\ContactoController;
   use Lib\Router;
   use Controllers\ErrorController;

  class Routes{
    public static function index(){
        Router::add('GET','/', function (){
            return "Bienvenido";
        });

        Router::add('GET','/', function (){
            return (new ContactoController())->mostrarTodos();
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
    
    



    



    
