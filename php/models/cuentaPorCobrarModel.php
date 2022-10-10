<?php
  Class cuentaPorCobrarModel{
      private $objetoConn;
      private $conn;
      private $cuentas;

      function __construct(){
          require_once("../conexion/conexion.php");
          $this->objetoConn = new conexion();
          $this->conn = $this->objetoConn->conectar();

          $this->cuentas = array();
      }

      public function getCuentas(){
        $query = "SELECT * FROM cuentas_p_cobrar";
        if($r = mysqli_query($this->conn,$query)){
          while ($i = mysqli_fetch_array($r)){
            $this->cuentas[] = $i;
          }
          return $this->cuentas;
        }
        return -1;
      }

      public function getCuentaId($idCliente){
        $sentencia = " SELECT * FROM cuentas_p_cobrar WHERE id_cli = '$idCliente' ";
        if($result = mysqli_query($this->conn,$sentencia)){
          $v = mysqli_fetch_row($result);
          return $v[0];
        }else{return -1;}
      }

      public function getCuenta($id){
        $sentencia = "SELECT * FROM cuentas_p_cobrar WHERE id_cli ='$id'";
        $result = mysqli_query($this->conn,$sentencia);
        $v = mysqli_fetch_row($result);

        return $v[1];
      }

      public function saveCuenta($monto,&$idCliente){
        $sentencia = "INSERT into cuentas_p_cobrar (cuenta,id_cli) values ('$monto','$idCliente')";

        if(mysqli_query($this->conn,$sentencia)){
          return mysqli_insert_id($this->conn);
        }
        return -1;
      }

      public function update_cuenta($monto,&$idCliente){
        //Añade un monto al ya anterior
        $sentencia = "UPDATE cuentas_p_cobrar SET cuenta = cuenta + '$monto' WHERE id_cli = '$idCliente' ";
        return mysqli_query($this->conn,$sentencia);
      }

      public function setCuenta($monto,$idCliente){
        //Resta un monto al ya anterior
        $monto = round($monto * 1000,2);
        $sentencia = "UPDATE cuentas_p_cobrar SET cuenta = round((round((cuenta*1000),2) - ('$monto'))/1000,2) WHERE id_cli = '$idCliente' ";
        if(mysqli_query($this->conn,$sentencia)){
          return mysqli_affected_rows($this->conn);
        }

        return -1;
      }

  }
?>
