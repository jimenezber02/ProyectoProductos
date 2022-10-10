<?php
  require_once("../models/clienteModel.php");
  $clienteModel = new clienteModel();

  $datos = array(
    'id' => $_POST['idCliente'],
    'nombre' => $_POST['inputNombreC'],
    'apellido' => $_POST['inputApe'],
    'cedula' => $_POST['inputCed']
  );

  echo($clienteModel -> updateCliente($datos));
?>
