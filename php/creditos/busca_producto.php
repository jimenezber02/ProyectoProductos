<?php 
    include("../conexion/conexion.php");
    include("clase_creditos.php");

    $obj = new clase_creditos();

    echo(json_encode($obj -> busca_producto($_POST['codigo'])));
?>