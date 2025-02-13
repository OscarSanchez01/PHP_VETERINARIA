<?php
require_once __DIR__ . '/../services/clienteService.php';
require_once __DIR__ . '/../models/clienteModel.php';

class ClienteController {
    private $clienteService;

    public function __construct($conexion) {
        $this->clienteService = new ClienteService($conexion);
    }

    public function insertarCliente($datos) {
        return $this->clienteService->insertarCliente(
            $datos['dni'], $datos['nombre'], $datos['apellido1'], $datos['apellido2'], 
            $datos['direccion'], $datos['tlfno']
        );
    }

    public function borrarCliente($dni) {
        return $this->clienteService->borrarCliente($dni);
    }

    public function obtenerPerrosPorCliente($dni) {
        return $this->clienteService->obtenerPerrosPorCliente($dni);
    }
}
?>