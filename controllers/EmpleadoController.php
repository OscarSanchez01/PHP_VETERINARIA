<?php
require_once "../services/EmpleadoService.php";

class EmpleadoController {
    public function listarEmpleados() {
        return EmpleadoService::getEmpleados();
    }
}
?>
