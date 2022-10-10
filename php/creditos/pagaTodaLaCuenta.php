<?php 
	include('../conexion/conexion.php');
	include('clase_creditos.php');

	$ob = new clase_creditos();

	echo($ob-> pagaTodaLaCuenta($_POST['idCuenta'],$_POST['cuentaCredito']));
?>