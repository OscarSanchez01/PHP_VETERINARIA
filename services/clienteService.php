<?php
class ClienteService {
    private $db;
    
    public function __construct($conexion) {
        $this->db = $conexion;
    }
    
    public function insertarCliente($dni, $nombre, $apellido1, $apellido2, $direccion, $tlfno) {
        if (empty($dni) || empty($nombre) || empty($apellido1) || empty($apellido2)) {
            return "Faltan datos";
        }
        
        $query = "SELECT Dni FROM clientes WHERE Dni = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            return "El Cliente ya está dado de alta";
        }
        
        $query = "INSERT INTO clientes (Dni, Nombre, Apellido1, Apellido2, Direccion, Tlfno) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssss", $dni, $nombre, $apellido1, $apellido2, $direccion, $tlfno);
        
        if ($stmt->execute()) {
            return "Cliente DNI: $dni insertado correctamente";
        } else {
            return "Error al insertar el cliente";
        }
    }
    
    public function borrarCliente($dni) {
        $query = "SELECT Dni FROM clientes WHERE Dni = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 0) {
            return "El cliente no existe";
        }
        
        $query = "DELETE FROM perros WHERE DniCliente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        
        $query = "DELETE FROM clientes WHERE Dni = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $dni);
        
        if ($stmt->execute()) {
            return "Cliente DNI: $dni borrado correctamente";
        } else {
            return "Error al borrar el cliente";
        }
    }
    
    public function obtenerPerrosPorCliente($dni_cliente) {
        $query = "SELECT * FROM perros WHERE Dni_duenio = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $dni_cliente);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $perros = [];
        while ($fila = $resultado->fetch_assoc()) {
            $perros[] = $fila;
        }
        
        if (empty($perros)) {
            return "El cliente no tiene perros registrados";
        }
        
        return $perros;
    }
}
?>