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

    public function registroUsuario() {
        // Verifica si se ha enviado el formulario de registro
        if (isset($_POST['registro'])) {
            // Obtiene los datos del formulario
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $email = $_POST['email'];
            $contrasena = $_POST['contrasena'];
            $rol = 'usur'; // Todos los usuarios son 'usur' por defecto
            
          
            // Validar y sanear los datos del usuario
            // $usuarioSaneado = $this->validarSanear($nombre, $apellidos, $email, $rol);
            // if (!$usuarioSaneado) {
            //     // Si los datos no son válidos, detiene el proceso de registro
            //     return;
            // }
    
            // // Los datos saneados ahora están disponibles para su uso
            // $nombre = $usuarioSaneado['nombre'];
            // $apellidos = $usuarioSaneado['apellidos'];
            // $email = $usuarioSaneado['email'];
            // $username = $usuarioSaneado['username'];
            // $rol = $usuarioSaneado['rol'];
    
            // Llama al servicio de usuarios para registrar al usuario con los datos saneados
            $usuariosService = new UsuariosService();
            $resultado = $usuariosService->register($nombre, $apellidos, $email, $contrasena, $rol);
    
            // Ejecuta la función mostrarBlog()
            $this->mostrarTodos();
    
            // Sal del método registroUsuario()
            return;
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




}
