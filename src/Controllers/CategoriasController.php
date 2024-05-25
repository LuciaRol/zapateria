<?php

namespace Controllers;
use Services\CategoriasService;
use Lib\Pages;
use Models\Categoria; // Importa el modelo Categoria

class CategoriasController {

    private Pages $pagina;
    private CategoriasService $categoriasService;

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de categorías
        $this->categoriasService = new CategoriasService();
    }

    public function mostrarTodos() {
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

        // Devolver la renderización de la página con los objetos de categoría
        return $this->pagina->render('mostrarPrincipal', ['categorias' => $categoriasModel]);
    }
}
