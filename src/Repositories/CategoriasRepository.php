<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Blog;
    use PDOException;
    use PDO;
    class categoriasRepository{
        private DataBase $conexion;
        private mixed $sql;
        function __construct(){
            $this->conexion = new DataBase();
        }
        public function findAll(): array|string|null{
            $categoriaCommit = null;
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT *  	                                                               
                                                            FROM categorias");
                
                $this->sql->execute();
                $categoriaCommitData = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $categoriaCommit = $categoriaCommitData ?: null;
                
            } catch (PDOException $e) {
                $categoriaCommit = $e->getMessage();
            }
        
            return $categoriaCommit;
        }
        
        public function guardarCategoria(string $nombreCategoria, string $imagen): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("INSERT INTO categorias (nombre, imagen) VALUES (:nombre, :imagen)");
                $this->sql->bindParam(':nombre', $nombreCategoria, PDO::PARAM_STR);
                $this->sql->bindParam(':imagen', $imagen, PDO::PARAM_STR);
                $this->sql->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        
    }