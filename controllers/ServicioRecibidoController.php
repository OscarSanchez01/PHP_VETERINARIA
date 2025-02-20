<?php
require_once "../services/ServicioRecibidoService.php";

class ServicioRecibidoController {
    public function listarServiciosRecibidos() {
        return ServicioRecibidoService::getServiciosRecibidos();
    }
}
?>
