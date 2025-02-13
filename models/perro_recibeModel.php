<?php
class PerroRecibeModel {
    private $sr_cod;
    private $id_perro;
    private $dni_empleado;
    private $cod_servicio;
    private $precio;
    private $fecha_servicio;
    private $incidencia;
    
    public function __construct($sr_cod, $id_perro, $dni_empleado, $cod_servicio, $precio, $fecha_servicio, $incidencia) {
        $this->sr_cod = $sr_cod;
        $this->id_perro = $id_perro;
        $this->dni_empleado = $dni_empleado;
        $this->cod_servicio = $cod_servicio;
        $this->precio = $precio;
        $this->fecha_servicio = $fecha_servicio;
        $this->incidencia = $incidencia;
    }
    
    public function getSrCod() {
        return $this->sr_cod;
    }
    
    public function getIdPerro() {
        return $this->id_perro;
    }
    
    public function getDniEmpleado() {
        return $this->dni_empleado;
    }
    
    public function getCodServicio() {
        return $this->cod_servicio;
    }
    
    public function getPrecio() {
        return $this->precio;
    }
    
    public function getFechaServicio() {
        return $this->fecha_servicio;
    }
    
    public function getIncidencia() {
        return $this->incidencia;
    }
    
    public function setSrCod($sr_cod) {
        $this->sr_cod = $sr_cod;
    }
    
    public function setIdPerro($id_perro) {
        $this->id_perro = $id_perro;
    }
    
    public function setDniEmpleado($dni_empleado) {
        $this->dni_empleado = $dni_empleado;
    }
    
    public function setCodServicio($cod_servicio) {
        $this->cod_servicio = $cod_servicio;
    }
    
    public function setPrecio($precio) {
        $this->precio = $precio;
    }
    
    public function setFechaServicio($fecha_servicio) {
        $this->fecha_servicio = $fecha_servicio;
    }
    
    public function setIncidencia($incidencia) {
        $this->incidencia = $incidencia;
    }
}
?>