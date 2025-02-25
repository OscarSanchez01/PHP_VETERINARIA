<?php
require_once "../services/ServicioRealizadoService.php";

class ServicioRealizadoController
{

    public function listarServiciosRealizados()
    {
        return ServicioRealizadoService::getServicios();
    }

    public function agregarServicioRealizado($data)
    {
        return ServicioRealizadoService::addServicioRealizado($data);
    }
    public function actualizarServicioRealizado($data)
    {
        require_once "../services/ServicioRealizadoService.php";
        return ServicioRealizadoService::updateServicioRealizado($data);
    }


    public function eliminarServicioRealizado($sr_cod)
    {
        return ServicioRealizadoService::deleteServicioRealizado($sr_cod);
    }

    public function listarServiciosPorEmpleado($dni_empleado) {
        return ServicioRealizadoService::getServicios($dni_empleado);
    }
    
}
