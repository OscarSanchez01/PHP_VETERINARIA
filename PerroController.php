<?php
require_once "../services/PerroService.php";

class PerroController {
    public function listarPerros() {
        return PerroService::getPerros();
    }

    public function eliminarPerro($ID_Perro) {
        return PerroService::deletePerro($ID_Perro);
    }

    
    public function listarPerrosPorCliente($dni_cliente) {
        return PerroService::getPerrosPorCliente($dni_cliente);
    }
}
?>
