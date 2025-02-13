<?php
class PerroRecibeService {
    private $db;
    
    public function __construct($conexion) {
        $this->db = $conexion;
    }
    
    public function insertarServicioPerro($id_perro, $dni_empleado, $cod_servicio, $precio, $fecha_servicio = null) {
        if (empty($id_perro) || empty($dni_empleado) || empty($cod_servicio) || empty($precio)) {
            return "Faltan datos";
        }
        
        $fecha_actual = date('Y-m-d');
        if ($fecha_servicio === null) {
            $fecha_servicio = $fecha_actual;
        } elseif ($fecha_servicio > $fecha_actual) {
            return "Fecha incorrecta";
        }
        
        if (!is_numeric($precio) || $precio < 0) {
            return "Precio incorrecto";
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
        
        $query = "SELECT ID_Perro FROM perros WHERE ID_Perro = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_perro);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            return "El perro no existe";
        }
        $stmt->close();
        
        $query = "SELECT Dni, Profesion FROM empleados WHERE Dni = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $dni_empleado);
        $stmt->execute();
        $stmt->store_result();
        
        $dni_valido = "";
        $profesion = "";
        
        if ($stmt->num_rows === 0) {
            return "El empleado no existe";
        }
        
        $stmt->bind_result($dni_valido, $profesion);
        $stmt->fetch();
        $stmt->close();
        
        if (($profesion === 'NUTRICIONISTA' && strpos($cod_servicio, 'SVNUT') !== 0) ||
            ($profesion === 'ESTILISTA' && strpos($cod_servicio, 'SVBE') !== 0)) {
            return "El empleado no puede realizar este servicio";
        }
        
        $query = "INSERT INTO perro_recibe_servicio (ID_Perro, DNI_Empleado, Cod_Servicio, Precio, Fecha_Servicio) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("issds", $id_perro, $dni_empleado, $cod_servicio, $precio, $fecha_servicio);
        
        if ($stmt->execute()) {
            return "Servicio SR_COD insertado correctamente";
        } else {
            return "Error al insertar el servicio";
        }
    }
    
    public function borrarServicio($sr_cod) {
        $query = "SELECT SR_Cod FROM perro_recibe_servicio WHERE SR_Cod = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $sr_cod);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 0) {
            return "El servicio no existe";
        }
        $stmt->close();
        
        $query = "DELETE FROM perro_recibe_servicio WHERE SR_Cod = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $sr_cod);
        
        if ($stmt->execute()) {
            return "Servicio código: $sr_cod borrado correctamente";
        } else {
            return "Error al borrar el servicio";
        }
    }
    
    public function obtenerServiciosPorEmpleado($dni_empleado) {
        $query = "SELECT SR_Cod, Fecha_Servicio, Cod_Servicio, ID_Perro, DNI_Empleado, Precio, Incidencia 
                  FROM perro_recibe_servicio WHERE DNI_Empleado = ? ORDER BY Fecha_Servicio DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $dni_empleado);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $servicios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $servicios[] = $fila;
        }
        
        if (empty($servicios)) {
            return "El empleado no tiene servicios";
        }
        
        return $servicios;
    }

    public function obtenerTodosLosServicios() {
        $query = "SELECT SR_Cod, Fecha_Servicio, Cod_Servicio, ID_Perro, DNI_Empleado, Precio, Incidencia 
                  FROM perro_recibe_servicio ORDER BY Fecha_Servicio DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $servicios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $servicios[] = $fila;
        }
        
        if (empty($servicios)) {
            return "No hay servicios registrados";
        }
        
        return $servicios;
    }
}
?>