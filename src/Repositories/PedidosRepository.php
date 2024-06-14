<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Pedido;
    use PDOException;
    use PDO;
    class PedidosRepository{
        private DataBase $conexion;
        private mixed $sql;
        function __construct(){
            $this->conexion = new DataBase();
        }
        public function findAll():array|string|null {
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

        public function findPedidos($usuario_id): ?array {
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT * FROM pedidos WHERE usuario_id = :usuario_id");
                $this->sql->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $this->sql->execute();
                $pedidos = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                return $pedidos ?: null;
            } catch (PDOException $e) {
                return null;
            }
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

        public function buscarPedidoId(int $usuario_id, string $provincia, string $localidad, string $direccion, string $fecha_actual, string $hora_actual): ?int {
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT id 
                                                            FROM  Pedidos 
                                                            WHERE 
                                                            usuario_id = :usuario_id
                                                            AND provincia = :provincia
                                                            AND localidad = :localidad
                                                            AND direccion = :direccion
                                                            AND fecha = :fecha
                                                            AND hora = :hora
                                                            LIMIT 1");
                $this->sql->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $this->sql->bindParam(':provincia', $provincia, PDO::PARAM_STR);
                $this->sql->bindParam(':localidad', $localidad, PDO::PARAM_STR);
                $this->sql->bindParam(':direccion', $direccion, PDO::PARAM_STR);
                $this->sql->bindParam(':fecha', $fecha_actual, PDO::PARAM_STR);
                $this->sql->bindParam(':hora', $hora_actual, PDO::PARAM_STR);
                $this->sql->execute();
        
                // Fetch the pedido ID
                $pedidoId = $this->sql->fetchColumn();
        
                // If no pedido ID is found, return null
                if ($pedidoId === false) {
                    return null;
                }
        
                // Return the pedido ID as an integer
                return (int)$pedidoId;
            } catch (PDOException $e) {
                // Handle any potential exceptions here
                return null;
            }
        }
        

        public function guardarProductosPedido(int $pedido_id, int $producto_id, int $unidades): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) VALUES (:pedido_id, :producto_id, :unidades)");
                $this->sql->bindParam(':pedido_id', $pedido_id, PDO::PARAM_INT);
                $this->sql->bindParam(':producto_id', $producto_id, PDO::PARAM_STR);
                $this->sql->bindParam(':unidades', $unidades, PDO::PARAM_STR);
                $this->sql->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }


        public function nuevoEstado($pedido_id, $nuevo_estado):bool {
            try {
                $this->sql = $this->conexion->prepareSQL("
                                                            UPDATE pedidos SET 
                                                                estado = :nuevo_estado
                                                            WHERE id = :pedido_id
                                                        ");
                $this->sql->bindParam(':nuevo_estado', $nuevo_estado, PDO::PARAM_STR);
                $this->sql->bindParam(':pedido_id', $pedido_id, PDO::PARAM_INT);
                $this->sql->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        
    }