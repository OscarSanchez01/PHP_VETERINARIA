<?php
require_once __DIR__ . '/../services/servicioService.php';
require_once __DIR__ . '/../models/servicioModel.php';

class ServicioController {
    private $servicioService;

    public function __construct($conexion) {
        $this->servicioService = new ServicioService($conexion);
    }

    public function insertarServicio($datos) {
        return $this->servicioService->insertarServicio(
            $datos['nombre'], $datos['descripcion'], $datos['precio'], $datos['tipo']
        );
    }

    public function modificarPrecioServicio($cod_servicio, $nuevo_precio) {
        return $this->servicioService->modificarPrecioServicio($cod_servicio, $nuevo_precio);
    }
}
?>