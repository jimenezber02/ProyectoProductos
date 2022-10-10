<?php

class fechaPedidosModel
{
    private $conexion;
    private $conn;
    private $fechas;
    private $fechas_rec;
    private $fechas_ant;

    function __construct()
    {
        require_once("../conexion/conexion.php");
        $this->conexion = new conexion();
        $this->conn = $this->conexion->conectar();
        $this->fechas = array();
        $this->fechas_rec = array();
        $this->fechas_ant = array();
    }

    public function saveFecha($datos)
    {
        //$fecha = json_decode($datos["fecha"],true);
        $sentencia = "INSERT into pedidos (fecha,anio,mes,diaS,dia,valor,estado,comentario,id_cuentxcobrar) values (
      				'$datos[fecha]',
      				'$datos[anio]',
      				'$datos[mes]',
      				'$datos[diaLetra]',
      				'$datos[dia]',
      				'$datos[monto]',
      				'RECIENTE',
      				'$datos[comentario]',
      				'$datos[id]'
      			)";

        if (mysqli_query($this->conn, $sentencia)) {
            return mysqli_insert_id($this->conn);
        } else {
            return -1;
        }
    }

    public function updateFechaPedido($datos)
    {
        //Si edita, intenta retornar el id de la fila modificada
        $sentencia = "UPDATE pedidos SET valor = valor + '$datos[monto]' WHERE fecha='$datos[fecha]'
                                    AND estado='RECIENTE' AND id_cuentxcobrar='$datos[id]' ";
        if (mysqli_query($this->conn, $sentencia)) {
            if (mysqli_affected_rows($this->conn)) {
                $sql = "SELECT * FROM pedidos WHERE fecha='$datos[fecha]' AND estado='RECIENTE' AND id_cuentxcobrar='$datos[id]' ";
                if ($r = mysqli_query($this->conn, $sql)) {
                    $v = mysqli_fetch_array($r);

                    return $v[0];
                }
            } else {
                return $this->saveFecha($datos);
            }
        }
        return -1;
    }

    //TODO
    public function set_status_pedido($idCuenta)
    {
        $sentencia = "UPDATE pedidos SET estado = 'ANTERIOR' WHERE id_cuentxcobrar='$idCuenta' ";
        //$sentencia = "SELECT * FROM pedidos WHERE id_cuentxcobrar = '$idCuenta' ";

        if (mysqli_query($this->conn, $sentencia)) {
            return mysqli_affected_rows($this->conn);
        }
        return -1;
    }

    public function delete_pedidos($idCuenta)
    {
        $sentencia = "DELETE FROM pedidos WHERE id_cuentxcobrar='$idCuenta' ";
        if (mysqli_query($this->conn, $sentencia)) {
            return mysqli_affected_rows($this->conn);
        }
        return -1;
    }

    public function getFechas($id)
    {
        $sentencia = "SELECT * FROM pedidos WHERE id_cuentxcobrar='$id' AND estado='RECIENTE' OR estado='ANTERIOR' ";

        if ($r = mysqli_query($this->conn, $sentencia)) {
            while ($i = mysqli_fetch_array($r)) {
              $this->fechas[] = $i;
            }
            return $this->fechas;
        } else {
            return 0;
        }
    }

    public function getFechasRecientes($id){
      $sentencia = "SELECT * FROM pedidos WHERE id_cuentxcobrar='$id' AND estado='RECIENTE' ";

      if ($r = mysqli_query($this->conn, $sentencia)) {
          while ($i = mysqli_fetch_array($r)) {
              $this->fechas_rec[] = $i;
          }
          return $this->fechas_rec;
      } else {
        return 0;
      }
    }

    public function getFechasAnterior($id){
      $sentencia = "SELECT * FROM pedidos WHERE id_cuentxcobrar='$id' AND estado='ANTERIOR' ";

      if ($r = mysqli_query($this->conn, $sentencia)) {
          while ($i = mysqli_fetch_array($r)) {
              $this->fechas_ant[] = $i;
          }
          return $this->fechas_ant;
      } else {
        return 0;
      }
    }

    public function pagar_pedido($id){
      $sql = "UPDATE pedidos SET estado = 'PAGADO' WHERE id_ped = '$id' ";
      if($r = mysqli_query($this->conn,$sql)){
        if(mysqli_affected_rows($this->conn)>0){
          return true;
        }
      }

      return false;
    }
}

?>
