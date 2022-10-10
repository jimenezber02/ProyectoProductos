<?php
  require_once("../models/fechaPedidosModel.php");
  require_once("../models/cuentaPorCobrarModel.php");
  $fpm = new fechaPedidosModel();
  $cp = new cuentaPorCobrarModel();

  $idCli = $_POST['idCli'];//id cuenta
  $ID = $_POST['id'];//id pedido
  $monto = $_POST['monto'];//valor del pago

  $response = [
    "tabla_pedido" => $fpm->pagar_pedido($ID),
    "tabla_cuenta" => $cp->setCuenta($monto,$idCli)
  ];
  echo json_encode($response);
?>
