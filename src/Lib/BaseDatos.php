<?php

namespace Lib;
use PDO;
use PDOException;

class BaseDatos {

    private $conexion;
    private $resultado;

    private $servidor;
    private $usuario;
    private $pass;
    private $base_datos;

    public function __construct() {
        $this->servidor = $_ENV['BD_HOST'];
        $this->usuario = $_ENV['BD_USER'];
        $this->pass = $_ENV['PASS'];
        $this->base_datos = $_ENV['BD_DATABASE'];
        $this->conexion = $this->conectar();
    }

    private function conectar(): PDO{
        try{
            $opciones = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::MYSQL_ATTR_FOUND_ROWS => true,
            );
            $conexion = new PDO("mysql:host={$this->servidor};dbname={$this->base_datos}",$this->usuario,$this->pass,$opciones);
            return $conexion;
        }catch(PDOException $e){
            echo "Ha surgido un error y no se puede conectar a la base de datos. Detalle: " . $e->getMessage();
            exit;
        }
    }

    public function consulta (string $consultaSQL): void{
        $this->resultado = $this->conexion->query($consultaSQL);
    }

    public function extraer_registro() : mixed{
        return ($fila = $this->resultado->fetch(PDO::FETCH_ASSOC))? $fila:false;
    }

    public function extraer_todos(): array {
        return $this->resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cierraConexion():void{
        $this->conexion=null;
    }

    public function prepara($pre){
        return $this->conexion->prepare($pre);
    }
}