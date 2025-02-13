<?php
class PerroModel {
    private $id_perro;
    private $dni_duenio;
    private $nombre;
    private $fecha_nto;
    private $raza;
    private $peso;
    private $altura;
    private $observaciones;
    private $numero_chip;
    private $sexo;
    
    public function __construct($id_perro, $dni_duenio, $nombre, $fecha_nto, $raza, $peso, $altura, $observaciones, $numero_chip, $sexo) {
        $this->id_perro = $id_perro;
        $this->dni_duenio = $dni_duenio;
        $this->nombre = $nombre;
        $this->fecha_nto = $fecha_nto;
        $this->raza = $raza;
        $this->peso = $peso;
        $this->altura = $altura;
        $this->observaciones = $observaciones;
        $this->numero_chip = $numero_chip;
        $this->sexo = $sexo;
    }
    
    public function getIdPerro() {
        return $this->id_perro;
    }
    
    public function getDniDuenio() {
        return $this->dni_duenio;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function getFechaNto() {
        return $this->fecha_nto;
    }
    
    public function getRaza() {
        return $this->raza;
    }
    
    public function getPeso() {
        return $this->peso;
    }
    
    public function getAltura() {
        return $this->altura;
    }
    
    public function getObservaciones() {
        return $this->observaciones;
    }
    
    public function getNumeroChip() {
        return $this->numero_chip;
    }
    
    public function getSexo() {
        return $this->sexo;
    }
    
    public function setIdPerro($id_perro) {
        $this->id_perro = $id_perro;
    }
    
    public function setDniDuenio($dni_duenio) {
        $this->dni_duenio = $dni_duenio;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function setFechaNto($fecha_nto) {
        $this->fecha_nto = $fecha_nto;
    }
    
    public function setRaza($raza) {
        $this->raza = $raza;
    }
    
    public function setPeso($peso) {
        $this->peso = $peso;
    }
    
    public function setAltura($altura) {
        $this->altura = $altura;
    }
    
    public function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }
    
    public function setNumeroChip($numero_chip) {
        $this->numero_chip = $numero_chip;
    }
    
    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }
}
?>