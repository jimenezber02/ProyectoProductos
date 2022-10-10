<?php
  /**
   *
   */
  class clienteClase
  {
    private $nombre;
    private $apellido;
    private $cedula;
    function __construct($nomb,$ape,$ced)
    {
      // code...
      $this->nombre = $nomb;
      $this->apellido = $ape;
      $this->cedula = $ced;
    }

    public function getNombre(){
      return $this->nombre;
    }
    public function setNombre($nomb){
      $this->nombre = $nomb;
    }

    public function getApellido(){
      return $this->apellido;
    }
    public function setApellido($ape){
      $this->apellido = $ape;
    }

    public function getCedula(){
      return $this->cedula;
    }
    public function setCedula($cedula){
      $this->cedula = $cedula;
    }
  }

?>
