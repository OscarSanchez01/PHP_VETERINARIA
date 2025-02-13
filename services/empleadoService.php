<?php
class EmpleadoService {
    private $db;
    
    public function __construct($conexion) {
        $this->db = $conexion;
    }
    
    public function insertarEmpleado($dni, $nombre, $apellido1, $apellido2, $direccion, $tlfno, $password, $rol, $profesion) {
        $rolesPermitidos = ['EMPLEADO', 'AUXILIAR', 'ADMIN'];
        $profesionesPermitidas = ['ESTILISTA', 'NUTRICIONISTA', 'AUXILIAR', 'ATT.CLIENTE'];
        
        if (empty($dni) || empty($nombre) || empty($apellido1) || empty($apellido2) || empty($password) || empty($rol) || empty($profesion)) {
            return "Faltan datos";
        }
        
        if (!in_array($rol, $rolesPermitidos) || !in_array($profesion, $profesionesPermitidas)) {
            return "Rol o profesión inválidos";
        }
        
        $query = "SELECT Dni FROM empleados WHERE Dni = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            return "El Empleado ya está dado de alta";
        }
        
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        
        $query = "INSERT INTO empleados (Dni, Nombre, Apellido1, Apellido2, Direccion, Tlfno, Password, Rol, Profesion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssssssss", $dni, $nombre, $apellido1, $apellido2, $direccion, $tlfno, $passwordHash, $rol, $profesion);
        
        if ($stmt->execute()) {
            return "Empleado DNI: $dni insertado correctamente";
        } else {
            return "Error al insertar el empleado";
        }
    }
}
?>