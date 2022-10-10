<?php  
	include('../conexion/conexion.php');
	include('clase_creditos.php');

	$obj = new clase_creditos();
	$result = $obj-> retorna_cuenta_anterior($_POST['idC']);
	if($result != -1){
		echo(json_encode($result));
	}else{
		echo($result);
	}
	
?>