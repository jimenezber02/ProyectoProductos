<?php
  include("../conexion/conexion.php");
  include("clase_creditos.php");
  include('../saldos/clase_saldo.php');

  $obj = new clase_creditos();
  echo($obj->elimina_cliente($_POST['id']));
?>
