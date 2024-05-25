<?php

namespace Models;
use Lib\BaseDatos;
use PDO;
use PDOException;
use Lib\Pages;

class Contacto {

    private BaseDatos $conexion;
    private mixed $stmt;
 
    private $id;
    private $nombre;
    private $apellidos;
    private $correo;
    private $direccion;
    private $telefono;
    private $fecha_nacimiento;

    private $pages;
    
    function __construct (){
        $this->id = null;
        $this->nombre = '';
        $this->apellidos = '';
        $this->correo = '';
        $this->direccion = '';
        $this->telefono = '';
        $this->fecha_nacimiento = null;
        $this->conexion = new BaseDatos();
    }
    

    // id
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    // nombre
    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    // apellidos
    public function getApellidos() {
        return $this->apellidos;
    }
    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    // correo
    public function getCorreo() {
        return $this->correo;
    }
    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    // direccion
    public function getDireccion() {
        return $this->direccion;
    }
    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    // telefono
    public function getTelefono() {
        return $this->telefono;
    }
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    // fecha de nacimiento
    public function getFechaNacimiento() {
        return $this->fecha_nacimiento;
    }
    public function setFechaNacimiento($fecha_nacimiento) {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    public function conseguirTodos() {
        return "Mostraremos todos los contactos de nuestra agenda";
    }

    // metodo que coge un array y lo convierte en un objeto contacto
    public static function fromArray(array $data) {
        $contacto = new Contacto();
        $contacto->setId($data['id'] ?? null);
        $contacto->setNombre($data['nombre'] ?? '');
        $contacto->setApellidos($data['apellidos'] ?? '');
        $contacto->setCorreo($data['correo'] ?? '');
        $contacto->setDireccion($data['direccion'] ?? '');
        $contacto->setTelefono($data['telefono'] ?? '');
        $contacto->setFechaNacimiento($data['fecha_nacimiento'] ?? '');
        
        return $contacto;
    }

    // devuelve un array de objetos contacto
    public function findAll(): ?array {
        try{
            $this->conexion->consulta("SELECT * FROM contactos");
            $contactos = $this->extractAll();
        }
        catch(PDOException $e) {
            $contactos = null;
        }
        return $contactos;
    }

    

    public function extractAll(){
        $contactos = [];
        try{
            $contactosData = $this->conexion->extraer_todos();
            foreach ($contactosData as $contactoData) {
                $contactos[] = Contacto::fromArray($contactoData);
            }
        }
        catch(PDOException $err){
            $contactos = null;  
        }
        return $contactos;
    }

    public function showAll(){
        $contactos = $this->findAll();
        var_dump($contactos);
        $this->pages->render('contacto/showContacts',['contactos'=>$contactos]);
    }

    public function read(int $id): ?Contacto{
        try {
            $consulta = "SELECT id, nombre, apellidos FROM contactos WHERE id = :id";
            $stmt = $this->conexion->prepara($consulta);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $contactoObtenido = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            $stmt = null;
            return ($contactoObtenido) ? Contacto::fromArray($contactoObtenido) : null;
        } catch (PDOException $e) {
            echo "No se han podido leer los datos ". $e->getMessage();
            return null;
        }
    }
 

    // CONSULTA PREPARADA PARA INSERTAR UN CONTACTO
    public function insertarContacto(Contacto $nuevoContacto): bool {
        try {
            $consulta = "INSERT INTO contactos (nombre, apellidos) VALUES (:nombre, :apellidos, :correo, :direccion, :telefono, :fecha_nacimiento)";
            $stmt = $this->conexion->prepara($consulta);
            $stmt->bindValue(':nombre', $nuevoContacto->getNombre(), PDO::PARAM_STR);
            $stmt->bindValue(':apellidos', $nuevoContacto->getApellidos(), PDO::PARAM_STR);
            $stmt->bindValue(':correo', $nuevoContacto->getApellidos(), PDO::PARAM_STR);
            $stmt->bindValue(':direccion', $nuevoContacto->getApellidos(), PDO::PARAM_STR);
            $stmt->bindValue(':telefono', $nuevoContacto->getApellidos(), PDO::PARAM_STR);
            $stmt->bindValue(':fecha_nacimiento', $nuevoContacto->getApellidos(), PDO::PARAM_STR);
            $stmt->execute();

            $filasInsertadas = $stmt->rowCount();
            $stmt->closeCursor();
            $stmt = null;
            return $filasInsertadas > 0;
        } catch (PDOException $e) {
            echo "Error al insertar el contacto: ". $e->getMessage();
            return false;
        }
    }

    // MODIFICAR CUALQUIER CONTACTO
    public function modificarContacto(Contacto $contactoExistente): bool {
        try {
            // consulta preparada
            $consulta = "UPDATE contactos SET 
                nombre = :nombre, 
                apellidos = :apellidos, 
                correo = :correo, 
                direccion = :direccion, 
                telefono = :telefono, 
                fecha_nacimiento = :fecha_nacimiento 
                WHERE id = :id";

            $stmt = $this->conexion->prepara($consulta);
            $stmt->bindValue(':nombre', $contactoExistente->getNombre(), PDO::PARAM_STR);
            $stmt->bindValue(':apellidos', $contactoExistente->getApellidos(), PDO::PARAM_STR);
            $stmt->bindValue(':correo', $contactoExistente->getCorreo(), PDO::PARAM_STR);
            $stmt->bindValue(':direccion', $contactoExistente->getDireccion(), PDO::PARAM_STR);
            $stmt->bindValue(':telefono', $contactoExistente->getTelefono(), PDO::PARAM_STR);
            $stmt->bindValue(':fecha_nacimiento', $contactoExistente->getFechaNacimiento(), PDO::PARAM_STR);
            $stmt->bindValue(':id', $contactoExistente->getId(), PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $stmt->closeCursor();
                return true;
            } else {
                $stmt->closeCursor();
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al modificar el contacto: " . $e->getMessage();
            return false;
        }
    }

    // MODIFICAR LOS DATOS DE LOS CONTACTOS ID1, ID2, ID3
    public function actualizarContactos(array $ids, string $nuevaDireccion): bool {
        try {
            $consulta = "UPDATE contactos SET direccion = :direccion WHERE id = :id";
            $stmt = $this->conexion->prepara($consulta);
            
            $stmt->bindParam(':direccion', $nuevaDireccion, PDO::PARAM_STR);
    
            // Se ejecuta la consulta para cada id
            foreach ($ids as $id) {
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
    
                // Verificamos si la actualización fue exitosa para el ID actual
                if ($stmt->rowCount() == 0) {
                    echo "Advertencia: No se encontró o no se actualizó ningún registro para el ID: $id\n";
                }
            }
            return true;

        } catch (PDOException $e) {
            echo "Error al actualizar las direcciones de contacto: " . $e->getMessage();
            return false;
        }
    }

    // MÉTODO ANÓNIMO PARA CREAR UNA CONSULTA QUE BORRE UN CONTACTO DE ID CONOCIDO
    public function borrarContacto(){

    }
    


}


    
    




