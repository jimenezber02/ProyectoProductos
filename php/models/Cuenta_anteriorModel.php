<?php
  /**
   *
   */
  class Cuenta_anteriorModel
  {
    private $conexion;
    private $conectar;

    function __construct()
    {
      // code...
      require_once("../conexion/conexion.php");
      $this->conexion = new Conexion();
      $this->conectar = $this->conexion->conectar();
    }

    public function getCuenta_anterior($id){
      $sql = "SELECT nombre,apellido,cedula,monto FROM clientes LEFT JOIN deuda_anteriores ON deuda_anteriores.id_cuentxcobrar = clientes.id_cli WHERE clientes.id_cli = '$id' ";

      if($result = mysqli_query($this->conectar,$sql)){
        $fetch = mysqli_fetch_row($result);
        if($fetch){
          return $fetch;
        }
      }
      return -1;
    }
  }

?>
