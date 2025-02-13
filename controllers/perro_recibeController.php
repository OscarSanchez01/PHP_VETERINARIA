<?php
require_once __DIR__ . '/../services/perro_recibeService.php';
require_once __DIR__ . '/../models/perro_recibeModel.php';

class PerroRecibeController {
    private $perroRecibeService;

    public function __construct($conexion) {
        $this->perroRecibeService = new PerroRecibeService($conexion);
    }

    public function insertarServicioPerro($datos) {
        return $this->perroRecibeService->insertarServicioPerro(
            $datos['id_perro'], $datos['dni_empleado'], $datos['cod_servicio'], 
            $datos['precio'], $datos['fecha_servicio']
        );
    }

    public function borrarServicio($sr_cod) {
        return $this->perroRecibeService->borrarServicio($sr_cod);
    }

    public function obtenerServiciosPorEmpleado($dni_empleado) {
        return $this->perroRecibeService->obtenerServiciosPorEmpleado($dni_empleado);
    }

    public function obtenerTodosLosServicios() {
        return $this->perroRecibeService->obtenerTodosLosServicios();
    }
}
?>