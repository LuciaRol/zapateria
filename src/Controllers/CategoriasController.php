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
    
        // Verificar si la sesión está activa y obtener el correo electrónico
        $emailSesion = isset($_SESSION['email']) ? $_SESSION['email'] : null;
    
        // Si no hay sesión activa, utilizar el correo electrónico recordado
        if (!$emailSesion && $emailRecordado) {
            $emailSesion = $emailRecordado;
        }
    
        // Devolver la renderización de la página con los objetos de categoría y el correo electrónico de la sesión
        return $this->pagina->render('mostrarPrincipal', ['categorias' => $categoriasModel, 'emailSesion' => $emailSesion]);
    }
    
}

