<?php
  require_once("../models/Cuenta_anteriorModel.php");

  $id = $_POST['id'];

  $cuentaAnteriorModel = new Cuenta_anteriorModel();

  echo(json_encode($cuentaAnteriorModel->getCuenta_anterior($id)));
?>
