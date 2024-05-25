<?php
    namespace Services;
    use Repositories\UsuariosRepository;
    use Models\Usuarios;
    class UsuariosService{
        // Creando variable con
        private UsuariosRepository $userRepository;
        function __construct() {
            $this->userRepository = new UsuariosRepository();
        }
       
        public function register($nombre, $apellidos, $email, $contrasena, $rol): ?string {
            // Llama al método del repositorio para insertar el usuario en la base de datos
            return $this->userRepository->registro($nombre, $apellidos, $email, $contrasena, $rol);
        }

        
        
    }