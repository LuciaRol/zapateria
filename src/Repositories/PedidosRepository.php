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
        
        public function guardarPedido(int $usuario_id, string $provincia, string $localidad, string $direccion, float $coste_total, string $estado, string $fecha, string $hora): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("INSERT INTO Pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES (:usuario_id, :provincia, :localidad, :direccion, :coste_total, :estado, :fecha, :hora)");
                $this->sql->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $this->sql->bindParam(':provincia', $provincia, PDO::PARAM_STR);
                $this->sql->bindParam(':localidad', $localidad, PDO::PARAM_STR);
                $this->sql->bindParam(':direccion', $direccion, PDO::PARAM_STR);
                $this->sql->bindParam(':coste_total', $coste_total, PDO::PARAM_STR);
                $this->sql->bindParam(':estado', $estado, PDO::PARAM_STR);
                $this->sql->bindParam(':fecha', $fecha, PDO::PARAM_STR);
                $this->sql->bindParam(':hora', $hora, PDO::PARAM_STR);
                $this->sql->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        
    }