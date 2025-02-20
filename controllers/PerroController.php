<?php
require_once "../services/PerroService.php";

class PerroController {
    public function listarPerros() {
        return PerroService::getPerros();
    }
}
?>
