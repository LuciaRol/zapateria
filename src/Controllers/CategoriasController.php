<?php

namespace Controllers;
use Services\CategoriasService;
use Lib\Pages;
use Models\Categoria; 
use Models\Validacion; 
use Services\UsuariosService; 


class CategoriasController {

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

    public function mostrarTodos($emailRecordado = null) {
        // Obtener todas las categorías
        $categorias = $this->categoriasService->obtenerCategorias();
    
        // Crear un array para almacenar los objetos de categoría
        $categoriasModel = [];
        foreach ($categorias as $categoria) {
            // Crear una nueva instancia de Categoria con los datos de la categoría
            $categoriaModel = new Categoria();
            $categoriaModel->setId($categoria['id']);
            $categoriaModel->setNombre($categoria['nombre']);
            // Agregar la instancia de Categoria al array
            $categoriasModel[] = $categoriaModel;
        }
        $usuarioController = new UsuarioController();
        // Obtener el email del usuario
        $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);
    
        // Devolver la renderización de la página con los objetos de categoría y el correo electrónico de la sesión
        return $this->pagina->render('mostrarCategorias', ['categorias' => $categoriasModel, 'emailSesion' => $emailSesion]);
    }
    
    public function registroCategoria($nombreCategoria) {
        $mensaje = ''; // Inicializamos la variable de mensaje
        
        $usuarioController = new UsuarioController();
        // Obtener el email del usuario
        // Verifica si el usuario está autenticado
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            
            // Verifica si el usuario tiene permisos de administrador
            if ($email->getRol() === 'admin') {
                // Después de verificar al usuario como administrador, guarda la nueva categoría si está presente en el formulario
                if (isset($_POST['nueva_categoria'])) {
                    $nombreCategoria = $_POST['nueva_categoria'];
                    $this->categoriasService->guardarCategoria($nombreCategoria);
                }
            } else {
                // Si el usuario no es administrador, asigna un mensaje indicando que no tiene permisos suficientes
                $mensaje = "No tienes permisos de administrador para registrar nuevas categorías.";
            }
        }
        
        $this-> mostrarTodos($email);
    }




}

