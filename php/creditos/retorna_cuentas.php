<?php
	include("../models/clienteModel.php");

	$clienteModel = new clienteModel();

	echo(json_encode($clienteModel-> getClientes()));
?>