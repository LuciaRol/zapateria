<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Blog;
    use Models\Validacion;
    use Models\Producto;
    use PDOException;
    use PDO;
    class productosRepository{
        private DataBase $conexion;
        private mixed $sql;
        function __construct(){
            $this->conexion = new DataBase();
        }
        public function findAll():array|string|null {
            $productoCommit = null;
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT    a.id, 
                                                                    a.categoria_id, 
                                                                    a.nombre, 
                                                                    a.descripcion, 
                                                                    a.precio, 
                                                                    a.stock, 
                                                                    a.oferta, 
                                                                    a.fecha, 
                                                                    a.imagen, 
                                                                    b.nombre as 'categoria' 
                                                        FROM productos a inner join categorias b on a.categoria_id = b.id");
                
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
        public function editarProducto(int $productoId, int $categoria_id, string $nombre, ?string $descripcion, float $precio, int $stock, ?string $oferta, string $fecha): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("UPDATE productos SET 
                                                            categoria_id = :categoria_id, 
                                                            nombre = :nombre, 
                                                            descripcion = :descripcion, 
                                                            precio = :precio, 
                                                            stock = :stock, 
                                                            oferta = :oferta, 
                                                            fecha = :fecha
                                                        WHERE id = :productoId");
                $this->sql->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
                $this->sql->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $this->sql->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
                $this->sql->bindParam(':precio', $precio, PDO::PARAM_STR);
                $this->sql->bindParam(':stock', $stock, PDO::PARAM_INT);
                $this->sql->bindParam(':oferta', $oferta, PDO::PARAM_STR);
                $this->sql->bindParam(':fecha', $fecha, PDO::PARAM_STR);
                
                $this->sql->bindParam(':productoId', $productoId, PDO::PARAM_INT);
                $this->sql->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
        
        public function bajarStockProductos(int $productoId, int $unidades): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("
                                                            UPDATE productos SET 
                                                                stock = stock - :unidades 
                                                            WHERE id = :productoId
                                                        ");
                $this->sql->bindParam(':unidades', $unidades, PDO::PARAM_INT);
                $this->sql->bindParam(':productoId', $productoId, PDO::PARAM_INT);
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
        public function eliminarProducto(int $id): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("DELETE FROM productos WHERE id = :id");
                $this->sql->bindParam(':id', $id, PDO::PARAM_INT);
                $this->sql->execute();
                
                // Verificar si se eliminó correctamente el producto
                return true;
                
            } catch (PDOException $e) {
                // Manejar la excepción si ocurre algún error durante la ejecución de la consulta
                return false;
            }
        }

        
        
        public function buscarProductos($descripcion):array|string|null {
            $productoCommit = null;
            try {

                $descripcion = strtolower($descripcion);
                $descripcion = '%' . $descripcion . '%';
                $this->sql = $this->conexion->prepareSQL("SELECT    a.id, 
                                                            a.categoria_id, 
                                                            a.nombre, 
                                                            a.descripcion, 
                                                            a.precio, 
                                                            a.stock, 
                                                            a.oferta, 
                                                            a.fecha, 
                                                            a.imagen, 
                                                            b.nombre as 'categoria' 
                                                    FROM productos a inner join categorias b on a.categoria_id = b.id
                                                    where LOWER(a.descripcion) like :descripcion or LOWER(a.nombre) like :descripcion or LOWER(b.nombre) like :descripcion");
                $this->sql->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
                $this->sql->execute();
                $productoCommitData = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $productoCommit = $productoCommitData ?: null;
                
            } catch (PDOException $e) {
                $productoCommit = $e->getMessage();
            }
        
            return $productoCommit;
        }
        
        








}