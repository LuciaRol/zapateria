<?php

namespace Controllers;
use Services\CategoriasService;
use Lib\Pages;
use Models\Categoria; 
use Models\Validacion; 
use Services\UsuariosService; 


class UsuarioController {

    private Pages $pagina;
    private CategoriasService $categoriasService;
    private UsuariosService $usuariosService;

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de categorías
        $this->categoriasService = new CategoriasService();
        
        $this->usuariosService = new UsuariosService();

    }

    public function registroUsuario($nombre, $apellidos, $email, $contrasena, $rol) {
        // Verificar si se ha enviado el formulario de registro
    
        $usuariosService = new UsuariosService();
        $resultado = $usuariosService->register($nombre, $apellidos, $email, $contrasena, $rol);
        $categoriasController = new CategoriasController();

        return $categoriasController->mostrarTodos();
        
        }
    
   
    public function login($email, $password) {
        
        $error = ''; // Creamos esta variable para que si todo va bien, no de error al mostrarBlog
    
        if ($email && $password) {
            $user = $this->usuariosService->verificaCredenciales($email, $password);
            if ($user) {
                session_start();
                $_SESSION['email'] = $user->getEmail();
                
                // Si se marca la casilla de "recordar usuario", establecer la cookie
                
                // Establecer el nombre de usuario como valor de la cookie
                setcookie("email_recordado", $user->getEmail(), time() + (30 * 24 * 60 * 60), "/");
                
                
            } else {
                $error = 'Email o contraseña incorrecta';
            }
        } 
    
        // Verificar si la cookie "email_recordado" existe y establecer la variable $emailRecordado
        $emailRecordado = isset($_COOKIE['email_recordado']) ? $_COOKIE['email_recordado'] : null;
    
        // Llama a mostrarBlog con el posible mensaje de error del login y la variable $emailRecordado
        $categoriasController = new CategoriasController();

        return $categoriasController->mostrarTodos($emailRecordado);
    }

    public function logout() {
        session_start();
        session_destroy();
        $categoriasController = new CategoriasController();

        return $categoriasController->mostrarTodos();
    }
    
}

    // public function validarSanear($nombre, $apellidos, $email, $rol) {
    //     // Validar los valores
    //     $errores = Validacion::validarDatosUsuario($nombre, $apellidos, $email, $rol);
    
    //     // Si hay errores, asignar el mensaje de error a una variable
    //     if (!empty($errores)) {
    //         $this->mostrarTodos(); 
    //         return false; // Indicar que hubo errores
    //     }
    
    //     // Saneamiento de los campos
    //     $usuarioSaneado = Validacion::sanearCamposUsuario($username, $nombre, $apellidos, $email, $rol);
       
        
    //     // Devolver los campos saneados
    //     return $usuarioSaneado;
    // }


