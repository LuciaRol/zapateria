<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Usuarios;
    use DateTime;
    use PDOException;
    use PDO;
    class UsuariosRepository{
        private DataBase $conexion;
        private mixed $sql;
        function __construct(){
            $this->conexion = new DataBase();
        }
        
        public function registro($nombre, $apellidos, $email, $contrasena, $rol): ?string {
            try {
                        // Cifra la contraseña
                $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);
                // Prepara y ejecuta la consulta SQL para insertar el usuario en la base de datos
                $this->sql = $this->conexion->prepareSQL("INSERT INTO usuarios (nombre, apellidos, email, contrasena, rol) VALUES (:nombre, :apellidos, :email, :contrasena, :rol);");
                $this->sql->bindValue(":nombre", "$nombre", PDO::PARAM_STR);
                $this->sql->bindValue(":apellidos", $apellidos, PDO::PARAM_STR);
                $this->sql->bindValue(":email", $email, PDO::PARAM_STR);
                $this->sql->bindValue(":contrasena", $contrasena_cifrada, PDO::PARAM_STR); // Guarda la contraseña cifrada
                $this->sql->bindValue(":rol", $rol, PDO::PARAM_STR);
                $this->sql->execute();
                $this->sql->closeCursor();
                $resultado = null;
            } catch (PDOException $e) {
                $resultado = $e->getMessage();
            }
            return $resultado;
        }

       
        
    }