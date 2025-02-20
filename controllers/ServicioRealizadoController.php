<?php
require_once "../services/ServicioRealizadoService.php";

class ServicioRealizadoController {
    public function listarServiciosRealizados() {
        return ServicioRealizadoService::getServicios();
    }

    public function listarServiciosPorEmpleado($dni_empleado) {
        return ServicioRealizadoService::getServicios($dni_empleado);
    }
}
?>
