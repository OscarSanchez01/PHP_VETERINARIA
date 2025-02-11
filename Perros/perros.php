<?php
// perros.php - Modelo de operaciones CRUD para la tabla PERROS
require_once "basedatos.php";

class Perro {
    private $conn;
    private $table_name = "PERROS";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Obtener todos los perros
    public function obtenerPerros() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un solo perro por ID
    public function obtenerPerroPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ID_Perro = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insertar un nuevo perro
    public function agregarPerro($dni_duenio, $nombre, $fecha_nto, $raza, $peso, $altura, $observaciones, $numero_chip, $sexo) {
        $query = "INSERT INTO " . $this->table_name . " (Dni_duenio, Nombre, Fecha_Nto, Raza, Peso, Altura, Observaciones, Numero_Chip, Sexo) 
                  VALUES (:dni_duenio, :nombre, :fecha_nto, :raza, :peso, :altura, :observaciones, :numero_chip, :sexo)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":dni_duenio", $dni_duenio);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":fecha_nto", $fecha_nto);
        $stmt->bindParam(":raza", $raza);
        $stmt->bindParam(":peso", $peso);
        $stmt->bindParam(":altura", $altura);
        $stmt->bindParam(":observaciones", $observaciones);
        $stmt->bindParam(":numero_chip", $numero_chip);
        $stmt->bindParam(":sexo", $sexo);
        
        return $stmt->execute();
    }

    // Actualizar perro
    public function actualizarPerro($id, $nombre, $peso, $altura, $observaciones) {
        $query = "UPDATE " . $this->table_name . " 
                  SET Nombre = :nombre, Peso = :peso, Altura = :altura, Observaciones = :observaciones 
                  WHERE ID_Perro = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":peso", $peso);
        $stmt->bindParam(":altura", $altura);
        $stmt->bindParam(":observaciones", $observaciones);
        
        return $stmt->execute();
    }

    // Eliminar perro
    public function eliminarPerro($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_Perro = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
