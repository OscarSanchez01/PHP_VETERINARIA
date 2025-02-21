<?php
require_once "../services/ServicioRealizadoService.php";

class ServicioRealizadoController {
    
    public function listarServiciosRealizados() {
        return ServicioRealizadoService::getServicios();
    }

    public function agregarServicioRealizado($data) {
        return ServicioRealizadoService::addServicioRealizado($data);
    }

    public function eliminarServicioRealizado($sr_cod) {
        return ServicioRealizadoService::deleteServicioRealizado($sr_cod);
    }
}
?>
