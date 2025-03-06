<?php
require_once "../services/ServicioService.php";

class ServicioController {
    public function listarServicios() {
        return ServicioService::getServicios();
    }

    public function eliminarServicio($codigo) {
        return ServicioService::deleteServicio($codigo);
    }
}
?>
