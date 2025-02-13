<?php
require_once "./../config/db.php";

class PerroService {
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "gromer");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function obtenerPerros() {
        $query = "SELECT * FROM perros";
        $resultado = $this->conexion->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function agregarPerro($dni_duenio, $nombre, $fecha_nto, $raza, $peso, $altura, $observaciones, $numero_chip, $sexo) {
        if (empty($dni_duenio) || empty($nombre) || empty($fecha_nto) || empty($raza) || empty($peso) || empty($altura) || empty($numero_chip) || empty($sexo)) {
            return "Error: Faltan datos obligatorios.";
        }

        $query_chip = "SELECT Numero_Chip FROM perros WHERE Numero_Chip = ?";
        $stmt_chip = $this->conexion->prepare($query_chip);
        $stmt_chip->bind_param("s", $numero_chip);
        $stmt_chip->execute();
        $stmt_chip->store_result();

        if ($stmt_chip->num_rows > 0) {
            return "Error: El perro con CHIP $numero_chip ya existe.";
        }
        $stmt_chip->close();

        $query_dueno = "SELECT Dni FROM clientes WHERE Dni = ?";
        $stmt_dueno = $this->conexion->prepare($query_dueno);
        $stmt_dueno->bind_param("s", $dni_duenio);
        $stmt_dueno->execute();
        $stmt_dueno->store_result();

        if ($stmt_dueno->num_rows == 0) {
            return "Error: El dueño con DNI $dni_duenio no está registrado.";
        }
        $stmt_dueno->close();

        $query_insert = "INSERT INTO perros (Dni_duenio, Nombre, Fecha_Nto, Raza, Peso, Altura, Observaciones, Numero_Chip, Sexo) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $this->conexion->prepare($query_insert);
        $stmt_insert->bind_param("ssssddsss", $dni_duenio, $nombre, $fecha_nto, $raza, $peso, $altura, $observaciones, $numero_chip, $sexo);
        $resultado = $stmt_insert->execute();

        if ($resultado) {
            return "Perro CHIP: $numero_chip insertado correctamente.";
        } else {
            return "Error: No se pudo insertar el perro.";
        }
    }

    public function eliminarPerro($numero_chip) {
        $query_verificar = "SELECT ID_Perro FROM perros WHERE Numero_Chip = ?";
        $stmt_verificar = $this->conexion->prepare($query_verificar);
        $stmt_verificar->bind_param("s", $numero_chip);
        $stmt_verificar->execute();
        $stmt_verificar->store_result();

        if ($stmt_verificar->num_rows == 0) {
            return "Error: El perro con CHIP $numero_chip no existe.";
        }

        $stmt_verificar->bind_result($id_perro);
        $stmt_verificar->fetch();
        $stmt_verificar->close();

        $query_actualizar_servicio = "UPDATE perro_recibe_servicio SET ID_Perro = NULL WHERE ID_Perro = ?";
        $stmt_actualizar_servicio = $this->conexion->prepare($query_actualizar_servicio);
        $stmt_actualizar_servicio->bind_param("i", $id_perro);
        $stmt_actualizar_servicio->execute();
        $stmt_actualizar_servicio->close();

        $query_eliminar = "DELETE FROM perros WHERE Numero_Chip = ?";
        $stmt_eliminar = $this->conexion->prepare($query_eliminar);
        $stmt_eliminar->bind_param("s", $numero_chip);
        $resultado = $stmt_eliminar->execute();

        if ($resultado) {
            return "Perro CHIP: $numero_chip borrado correctamente.";
        } else {
            return "Error: No se pudo eliminar el perro.";
        }
    }
}
?>
