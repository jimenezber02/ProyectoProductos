<?php  
	include("../conexion/conexion.php");
	//include("../creditos/clase_creditos.php");
	include("clase_saldo.php");

	$obj = new clase_saldo();

	echo(json_encode($obj-> busca_saldo($_POST['idCuenta'])));
?>