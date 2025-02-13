<?php
class ServicioModel {
    private $codigo;
    private $nombre;
    private $descripcion;
    private $precio;
    private $tipo;
    
    public function __construct($codigo, $nombre, $descripcion, $precio, $tipo) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->tipo = $tipo;
    }
    
    public function getCodigo() {
        return $this->codigo;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function getPrecio() {
        return $this->precio;
    }
    
    public function getTipo() {
        return $this->tipo;
    }
    
    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    
    public function setPrecio($precio) {
        $this->precio = $precio;
    }
    
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }
}
?>