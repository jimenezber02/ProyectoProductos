<?php  
	include('../conexion/conexion.php');
	include('clase_creditos.php');

	$obj = new clase_creditos();

	if($obj-> delete_cuenta_anterior($_POST['idCuenta']) > 0){
		$obj-> descuenta_abono($_POST['monto'],$_POST['idCuenta']);
		$obj-> eliminaFechaAnterior($_POST['idCuenta']);
		echo(1);
	}else{
		echo(0);
	}
?>