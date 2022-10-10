<?php
  require_once("../models/fechaPedidosModel.php");

  $fp = new fechaPedidosModel();
  $fechas["fechas"] = $fp->getFechas($idCliente);
  $recientes["recientes"] = $fp->getFechasRecientes($idCliente);
  $anterior["anterior"] = $fp->getFechasAnterior($idCliente);
?>
