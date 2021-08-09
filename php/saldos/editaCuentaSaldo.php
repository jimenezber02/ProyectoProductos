<?php  
	include('../conexion/conexion.php');
	include('../creditos/clase_creditos.php');
	include('clase_saldo.php');

	$obj = new clase_saldo();

	$datos = array(
		'id' => $_POST['id_cli'],
		'nombre' => $_POST['nombre'],
		'apellido' => $_POST['apellido'],
		'cedula' => $_POST['cedula'],
		'saldo' => $_POST['montoSaldo']
	);

	echo($obj-> updateCuentaSaldo($datos));
?>