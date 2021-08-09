<?php  
	include("../conexion/conexion.php");
	include("clase_creditos.php");

	$cred = new clase_creditos();

	echo(json_encode($cred-> tabla_fechas($_POST['idCuenta'])));
?>