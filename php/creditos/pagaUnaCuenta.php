<?php  
	include('../conexion/conexion.php');
	include('clase_creditos.php');

	$obj = new clase_creditos();

	if($obj-> pagaUnaFecha($_POST['idFecha']) > 0){
		$obj-> descuenta_abono($_POST['valor'],$_POST['idCuenta']);
		echo(1);
	}else{
		echo(0);
	}
?>