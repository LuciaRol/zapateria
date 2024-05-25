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

    public function registroUsuario($nombre, $apellidos, $email, $contrasena, $rol) {
        // Verificar si se ha enviado el formulario de registro
        if (isset($_POST['registro'])) {
            // Obtiene los datos del formulario
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $email = $_POST['email'];
            $contrasena = $_POST['contrasena'];
            $rol = 'usur'; // Todos los usuarios son 'usur' por defecto
            
            // Llama al servicio de usuarios para registrar al usuario con los datos obtenidos
            $usuariosService = new UsuariosService();
            $resultado = $usuariosService->register($nombre, $apellidos, $email, $contrasena, $rol);
    
            $this->mostrarTodos();
            exit; // Terminar la ejecución del script después de la redirección
            }
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


