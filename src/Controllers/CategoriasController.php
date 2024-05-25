<?php

namespace Controllers;
use Services\CategoriasService;
use Lib\Pages;
use Models\Contacto;

class CategoriasController {

    private Pages $pagina;

    private CategoriasService $categoriasService;
    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de entradas
        $this->categoriasService = new CategoriasService();

    }
    public function mostrarTodos() {
        $categorias = $this->categoriasService->obtenerCategorias();
        return $this->pagina->render('mostrarCategorias', ['categorias' => $categorias]);
    }
}

