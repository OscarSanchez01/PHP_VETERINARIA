<?php
require_once __DIR__ . '/../services/empleadoService.php';
require_once __DIR__ . '/../models/empleadoModel.php';

class EmpleadoController {
    private $empleadoService;

    public function __construct($conexion) {
        $this->empleadoService = new EmpleadoService($conexion);
    }

    public function insertarEmpleado($datos) {
        return $this->empleadoService->insertarEmpleado(
            $datos['dni'], $datos['nombre'], $datos['apellido1'], $datos['apellido2'], 
            $datos['direccion'], $datos['tlfno'], $datos['password'], 
            $datos['rol'], $datos['profesion']
        );
    }
}
?>