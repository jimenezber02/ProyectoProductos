<?php
  require_once("../models/Cuenta_anteriorModel.php");
  $cuenta_anteriorModel = new Cuenta_anteriorModel();
  $cuentaAnt = $cuenta_anteriorModel->getCuenta_anterior($idCliente);
?>
