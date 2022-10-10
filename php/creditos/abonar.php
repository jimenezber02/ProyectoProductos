<?php  
	include('../conexion/conexion.php');
	include('clase_creditos.php');

	$ob = new clase_creditos();
	$datos = array($_POST['elAbono'],$_POST['idCuenta']);

	$result = $ob-> descuenta_abono($datos[0],$datos[1]);
	if($result > 0){
		$result = $ob-> agrega_abono($datos[1]);
		if($result > 0){
			$result = $ob-> actualiza_fechas($datos[1]);
		}
		else if($result == 0){
			$result = $ob-> delete_pedido($datos[1]);
		}
	}

	echo($result);
?>