<?php
  include('../conexion/conexion.php');
  include('clase_creditos.php');

  $obj = new clase_creditos();

  $datos = array(
  	"monto" => $_POST['monto'],
  	"idCuenta" => $_POST['idCuenta'],
  	"fecha" => $_POST['fecha'],
  	"diaLetra" => $_POST['diaS'],
  	"mes" => $_POST['mes'],
  	"dia" => $_POST['dia'],
  	"anio" => $_POST['anio'],
    "coment" => $_POST['comentario'],
  	"datos" => $_POST['datos']
  );

  echo($obj -> nuevo_credito($datos));
?>
