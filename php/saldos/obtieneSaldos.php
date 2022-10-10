<?php
	include("../conexion/conexion.php");
	include("clase_saldo.php");

	$obj = new clase_saldo();

	echo(json_encode($obj->saldos()));  
?>