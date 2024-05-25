<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Blog;
    use PDOException;
    use PDO;
    class PedidosRepository{
        private DataBase $conexion;
        private mixed $sql;
        function __construct(){
            $this->conexion = new DataBase();
        }
        public function findAll() {
            $PedidoCommit = null;
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT *  	                                                               
                                                            FROM pedidos");
                
                $this->sql->execute();
                $PedidoCommitData = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $PedidoCommit = $PedidoCommitData ?: null;
                
            } catch (PDOException $e) {
                $PedidoCommit = $e->getMessage();
            }
        
            return $PedidoCommit;
        }
        
        public function guardarPedido(string $nombrePedido): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("INSERT INTO Pedidos (nombre) VALUES (:nombre)");
                $this->sql->bindParam(':nombre', $nombrePedido, PDO::PARAM_STR);
                $this->sql->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        
    }