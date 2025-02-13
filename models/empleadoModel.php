<?php
class EmpleadoModel {
    private $dni;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $direccion;
    private $tlfno;
    private $password;
    private $rol;
    private $profesion;
    
    public function __construct($dni, $nombre, $apellido1, $apellido2, $direccion, $tlfno, $password, $rol, $profesion) {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->direccion = $direccion;
        $this->tlfno = $tlfno;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->rol = $rol;
        $this->profesion = $profesion;
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
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getRol() {
        return $this->rol;
    }
    
    public function getProfesion() {
        return $this->profesion;
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
    
    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
    
    public function setRol($rol) {
        $this->rol = $rol;
    }
    
    public function setProfesion($profesion) {
        $this->profesion = $profesion;
    }
}
?>