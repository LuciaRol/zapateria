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

    public function mostrarTodos($emailRecordado = null, $mensaje = ''): void
    {
        $categoriasModel = $this->todasCategorias();
        
        $usuarioController = new UsuarioController();
        // Obtener el email del usuario
        $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);
        $rol = 'usur';
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            
            // Verifica si el usuario tiene permisos de administrador
            $rol = $email->getRol(); }

        // Devolver la renderización de la página con los objetos de categoría, el correo electrónico de la sesión y el mensaje
        $this->pagina->render('mostrarCategorias', [
            'categorias' => $categoriasModel, 
            'emailSesion' => $emailSesion, 
            'mensaje' => $mensaje,
            'rol' => $rol
        ]);
    }

    public function todasCategorias(): array {
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
        return $categoriasModel;
    }

    public function registroCategoria($nombreCategoria):void {
        $mensaje = 'Regístrate como admin para crear la categoría'; // Inicializamos la variable de mensaje
        
        $usuarioController = new UsuarioController();
        // Obtener el email del usuario
        // Verifica si el usuario está autenticado
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            
            // Verifica si el usuario tiene permisos de administrador
            if ($email->getRol() === 'admin') {
                $nombreCategoria = Validacion::sanearCategoria($nombreCategoria);
                

                if (empty($nombreCategoria)) {
                    // Si el nombre de la categoría está vacío, asignar un mensaje de error
                    $mensaje = "Debe proporcionar un nombre para la nueva categoría.";
                } else {
                    // Guardar la nueva categoría si no está vacía
                    $this->categoriasService->guardarCategoria($nombreCategoria);
                    $mensaje = "Categoría creada exitosamente.";
                }
            } else {
                // Si el usuario no es administrador, asigna un mensaje indicando que no tiene permisos suficientes
                $mensaje = "No tienes permisos de administrador para registrar nuevas categorías.";
            }
        }
        
        $this-> mostrarTodos($email, $mensaje);
    }

}

