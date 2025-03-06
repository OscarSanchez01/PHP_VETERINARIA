<?php
require_once "../services/ClienteService.php";

class ClienteController {
    public function listarClientes() {
        return ClienteService::getClientes();
    }

    public function eliminarCliente($dni) {
        return ClienteService::deleteCliente($dni);
    }
}
?>
