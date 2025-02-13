<?php
require_once __DIR__ . '/../services/perroService.php';
require_once __DIR__ . '/../models/perroModel.php';

class PerroController {
    private $perroService;

    public function __construct() {
        $this->perroService = new PerroService();
    }

    public function obtenerPerros() {
        return $this->perroService->obtenerPerros();
    }

    public function agregarPerro($datos) {
        return $this->perroService->agregarPerro(
            $datos['dni_duenio'], $datos['nombre'], $datos['fecha_nto'], $datos['raza'], 
            $datos['peso'], $datos['altura'], $datos['observaciones'], $datos['numero_chip'], 
            $datos['sexo']
        );
    }

    public function eliminarPerro($numero_chip) {
        return $this->perroService->eliminarPerro($numero_chip);
    }
}
?>