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
    private MailController $MailController;

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de categorías
        $this->categoriasService = new CategoriasService();
        
        $this->usuariosService = new UsuariosService();

        $this->MailController = new MailController();

    }

    public function registroUsuario($nombre, $apellidos, $email, $contrasena, $rol) {
        // Verificar si se ha enviado el formulario de registro
    
        $usuariosService = new UsuariosService();
        $resultado = $usuariosService->register($nombre, $apellidos, $email, $contrasena, $rol);
        
        $MailController = new MailController();
        $MailController->mailregistro($nombre, $email);

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
        $CategoriasController = new CategoriasController();

        return $CategoriasController->mostrarTodos($emailRecordado);
        
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
        $CategoriasController = new CategoriasController();

        return $CategoriasController->mostrarTodos();
    }
    public function sesion_usuario(): bool {
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
            $mensaje = "Tienes que registrarte para poder ver tu usuario";
            $categoriasController = new CategoriasController();
            return $categoriasController->mostrarTodos($emailSesion, $mensaje);
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

        if ($rol == 'admin'){

            $usuarios = $this->usuariosService->obtenerUsuarios();
            $data['usuarios'] = $usuarios;
        }
    
        // Renderizar la vista de usuario pasando las propiedades del usuario y el mensaje de error si existe
        $this->pagina->render("mostrarUsuario", $data);
        
    }

    public function mostrarRegistro($error = null) {
        // Obtener el email del usuario utilizando la función obtenerEmailUsuario
        
        // Renderizar la vista de usuario pasando las propiedades del usuario y el mensaje de error si existe
        $this->pagina->render("mostrarRegistro");
    }

    public function actualizarUsuario($nombre, $apellidos, $email, $rol) {
        // Validar y sanear los datos
        $usuarioValidado = $this->validarSaneaUsuario($nombre, $apellidos, $email, $rol);
        
        // Check if the user data is valid
        if (!$usuarioValidado) {
            // Handle invalid data, perhaps show an error message
            $error_message = "Error: Datos de usuario no válidos.";
            $this->mostrarUsuario($error_message);
            return;
        }
        $usuario = null;
        $usuarioController = new UsuarioController();

        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $usuario = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            // Verificar y asignar valores si son nulos
            }
        $nombre = $nombre !== null ? $nombre : $usuario->getNombre();
        $apellidos = $apellidos !== null ? $apellidos : $usuario->getApellidos();


    
        // Continuar con la actualización del usuario utilizando los campos saneados
        $resultado = $this->usuariosService->actualizarUsuario(
            $usuarioValidado['nombre'],
            $usuarioValidado['apellidos'],
            $usuarioValidado['email'],
            $usuarioValidado['rol']
        );
    
        if ($resultado === null) {
            // Redirigir a mostrar usuario si la actualización es exitosa
            $this->mostrarUsuario();
        } else {
            // Manejo de error si ocurre algún problema al actualizar el usuario
            $this->mostrarUsuario($resultado);
        }
    }
    
    public function validarSaneaUsuario( $nombre, $apellidos, $email, $rol) {
        // Validar los valores
        $errores = Validacion::validarDatosUsuario($nombre, $apellidos, $email, $rol);
    
        // Si hay errores, asignar el mensaje de error a una variable
        if (!empty($errores)) {
            $this->mostrarUsuario($errores);
            // Renderiza la vista de usuario pasando las propiedades del usuario
            

            return false; // Indicar que hubo errores
        }
    
        // Saneamiento de los campos
        $usuarioSaneado = Validacion::sanearCamposUsuario($nombre, $apellidos, $email, $rol);
        
        // Asignar los valores saneados de vuelta a las variables originales
        
        // Devolver los campos saneados
        return $usuarioSaneado;
    }


    
}


