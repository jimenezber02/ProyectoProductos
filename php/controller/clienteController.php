<?php
    //include("../conexion/conexion.php");
    include("../models/clienteModel.php");
    include("../models/cuentaPorCobrarModel.php");


    $clienteController = new clienteModel();
    $clientes['clientes'] = $clienteController->getClientes();

    //include("../tablas/tabla_creditos.php");
?>