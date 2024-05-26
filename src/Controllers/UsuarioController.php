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
        // Inicia la sesión si no ha sido iniciada ya
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Destruye la sesión
        session_destroy();
    
        // Elimina la cookie de email_recordado si existe
        if (isset($_COOKIE['email_recordado'])) {
            unset($_COOKIE['email_recordado']);
            setcookie('email_recordado', '', time() - 3600, '/');
        }
    
        // Redirige a mostrarTodos en CategoriasController
        $categoriasController = new CategoriasController();
        return $categoriasController->mostrarTodos();
    }
    private function sesion_usuario(): bool {
        // Inicia la sesión si no ha sido iniciada ya
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Verifica si el email del usuario está presente en la sesión
        return isset($_SESSION['email']);
    }

    // Función para obtener el email del usuario desde la sesión o la cookie
    function obtenerEmailUsuario($emailRecordado) {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Obtener el email de la sesión si está presente
        $emailSesion = isset($_SESSION['email']) ? $_SESSION['email'] : null;

        // Si no hay email en la sesión, intentar obtenerlo de la cookie
        if (!$emailSesion) {
            $emailSesion = $emailRecordado ?? (isset($_COOKIE['email_recordado']) ? $_COOKIE['email_recordado'] : null);
        }

        return $emailSesion;
    }
    public function mostrarUsuario($error = null) {
        // Obtener el email del usuario utilizando la función obtenerEmailUsuario
        $emailSesion = $this->obtenerEmailUsuario(null);
    
        // Si no hay email de sesión, redirigir a mostrarTodos en CategoriasController
        if (!$emailSesion) {
            $categoriasController = new CategoriasController();
            return $categoriasController->mostrarTodos();
        }
    
        // Obtén los datos del usuario autenticado
        $usuario = $this->usuariosService->obtenerUsuarioPorEmail($emailSesion);
        
        // Verificar si se encontró el usuario
        if (!$usuario) {
            return $this->pagina->render('error', ['message' => 'Usuario no encontrado.']);
        }
    
        // Obtén todas las propiedades del usuario
        $nombre = $usuario->getNombre();
        $apellidos = $usuario->getApellidos();
        $email = $usuario->getEmail();
        $rol = $usuario->getRol();
    
        // Preparar los datos para renderizar la vista de usuario
        $data = compact('nombre', 'apellidos', 'email', 'rol');
    
        // Agregar el mensaje de error a los datos si está presente
        if ($error !== null) {
            $data['error_message'] = $error;
        }
    
        // Renderizar la vista de usuario pasando las propiedades del usuario y el mensaje de error si existe
        $this->pagina->render("mostrarUsuario", $data);
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


