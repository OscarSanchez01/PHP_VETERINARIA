<?php
class ClienteModel {
    private $dni;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $direccion;
    private $tlfno;
    
    public function __construct($dni, $nombre, $apellido1, $apellido2, $direccion, $tlfno) {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->direccion = $direccion;
        $this->tlfno = $tlfno;
    }
    
    public function getDni() {
        return $this->dni;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function getApellido1() {
        return $this->apellido1;
    }
    
    public function getApellido2() {
        return $this->apellido2;
    }
    
    public function getDireccion() {
        return $this->direccion;
    }
    
    public function getTlfno() {
        return $this->tlfno;
    }
    
    public function setDni($dni) {
        $this->dni = $dni;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function setApellido1($apellido1) {
        $this->apellido1 = $apellido1;
    }
    
    public function setApellido2($apellido2) {
        $this->apellido2 = $apellido2;
    }
    
    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }
    
    public function setTlfno($tlfno) {
        $this->tlfno = $tlfno;
    }
}
?>