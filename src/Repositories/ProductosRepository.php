<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Blog;
    use PDOException;
    use PDO;
    class productosRepository{
        private DataBase $conexion;
        private mixed $sql;
        function __construct(){
            $this->conexion = new DataBase();
        }
        public function findAll() {
            $productoCommit = null;
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT *  	                                                               
                                                            FROM productos");
                
                $this->sql->execute();
                $productoCommitData = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $productoCommit = $productoCommitData ?: null;
                
            } catch (PDOException $e) {
                $productoCommit = $e->getMessage();
            }
        
            return $productoCommit;
        }
        
        public function guardarProducto(int $categoria_id, string $nombre, ?string $descripcion, float $precio, int $stock, ?string $oferta, string $fecha, ?string $imagen): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) 
                                                        VALUES (:categoria_id, :nombre, :descripcion, :precio, :stock, :oferta, :fecha, :imagen)");
                $this->sql->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
                $this->sql->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $this->sql->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
                $this->sql->bindParam(':precio', $precio, PDO::PARAM_STR);
                $this->sql->bindParam(':stock', $stock, PDO::PARAM_INT);
                $this->sql->bindParam(':oferta', $oferta, PDO::PARAM_STR);
                $this->sql->bindParam(':fecha', $fecha, PDO::PARAM_STR);
                $this->sql->bindParam(':imagen', $imagen, PDO::PARAM_STR);
                $this->sql->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
        
        

        public function findById(int $id): ?array {
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT * FROM productos WHERE id = :id");
                $this->sql->bindParam(':id', $id, PDO::PARAM_INT);
                $this->sql->execute();
                $producto = $this->sql->fetch(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                return $producto ?: null;
            } catch (PDOException $e) {
                return null;
            }
        }
    
        public function updateStock(int $id, int $nuevoStock): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("UPDATE productos SET stock = :stock WHERE id = :id");
                $this->sql->bindParam(':stock', $nuevoStock, PDO::PARAM_INT);
                $this->sql->bindParam(':id', $id, PDO::PARAM_INT);
                $this->sql->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        
    }