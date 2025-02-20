<?php
require_once "../services/ServicioService.php";

class ServicioController {
    public function listarServicios() {
        return ServicioService::getServicios();
    }
}
?>
