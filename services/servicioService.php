<?php
class ServicioService {
    private $db;
    
    public function __construct($conexion) {
        $this->db = $conexion;
    }
    
    public function insertarServicio($nombre, $descripcion, $precio, $tipo) {
        if (empty($nombre) || empty($descripcion) || empty($precio) || empty($tipo)) {
            return "Faltan datos";
        }
        
        if ($tipo === "BELLEZA") {
            $query_codigo = "SELECT MAX(CAST(SUBSTR(Codigo, 5) AS UNSIGNED)) + 1 AS SIGUIENTE FROM servicios WHERE SUBSTR(Codigo, 1, 4) = 'SVBE'";
            $codigo_prefijo = "SVBE";
        } elseif ($tipo === "NUTRICION") {
            $query_codigo = "SELECT MAX(CAST(SUBSTR(Codigo, 6) AS UNSIGNED)) + 1 AS SIGUIENTE FROM servicios WHERE SUBSTR(Codigo, 1, 5) = 'SVNUT'";
            $codigo_prefijo = "SVNUT";
        } else {
            return "Tipo de servicio inválido";
        }
        
        $resultado = $this->db->query($query_codigo);
        $fila = $resultado->fetch_assoc();
        $siguiente_codigo = $fila['SIGUIENTE'] ?? 1;
        $codigo = $codigo_prefijo . $siguiente_codigo;
        
        $query_verificar = "SELECT Codigo FROM servicios WHERE Codigo = ?";
        $stmt_verificar = $this->db->prepare($query_verificar);
        $stmt_verificar->bind_param("s", $codigo);
        $stmt_verificar->execute();
        $stmt_verificar->store_result();
        
        if ($stmt_verificar->num_rows > 0) {
            return "El Servicio ya está dado de alta";
        }
        
        $query_insert = "INSERT INTO servicios (Codigo, Nombre, Descripcion, Precio, Tipo) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $this->db->prepare($query_insert);
        $stmt_insert->bind_param("sssss", $codigo, $nombre, $descripcion, $precio, $tipo);
        
        if ($stmt_insert->execute()) {
            return "Servicio CODIGO: $codigo insertado correctamente";
        } else {
            return "Error al insertar el servicio";
        }
    }
    
    public function modificarPrecioServicio($cod_servicio, $nuevo_precio) {
        if (!is_numeric($nuevo_precio) || $nuevo_precio < 0) {
            return "Precio inválido";
        }
        
        $query = "SELECT Codigo FROM servicios WHERE Codigo = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $cod_servicio);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 0) {
            return "El servicio no existe";
        }
        $stmt->close();
        
        $query_update = "UPDATE servicios SET Precio = ? WHERE Codigo = ?";
        $stmt_update = $this->db->prepare($query_update);
        $stmt_update->bind_param("ds", $nuevo_precio, $cod_servicio);
        
        if ($stmt_update->execute()) {
            return "Precio del servicio $cod_servicio actualizado a $nuevo_precio";
        } else {
            return "Error al actualizar el precio del servicio";
        }
    }
}
?>