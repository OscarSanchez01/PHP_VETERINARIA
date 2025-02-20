<?php
require_once "../services/ClienteService.php";

class ClienteController {
    public function listarClientes() {
        return ClienteService::getClientes();
    }
}
?>
