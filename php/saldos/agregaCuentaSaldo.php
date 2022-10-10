<?php  
	include("../conexion/conexion.php");
	include("clase_saldo.php");
	include("../creditos/clase_creditos.php");

	$objeto = new clase_saldo();

	$data = array(
		"nombre"     => $_POST['nombre'],
        "apellido"   => $_POST['apellido'],
        "cedula"     => $_POST['cedula'],
        "montoSaldo" => $_POST['montoSaldo']
	);

	echo($objeto->crea_cuenta($data));
?>