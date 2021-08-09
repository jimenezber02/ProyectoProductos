<?php
  include("../conexion/conexion.php");
  include("clase_creditos.php");

  $obj = new clase_creditos();

  $datos = array(
    'id' => $_POST['id_cli'],
    'nombre' => $_POST['nombre'],
    'apellido' => $_POST['apellido'],
    'cedula' => $_POST['cedula']
  );

  echo($obj -> update_cliente($datos));
?>
