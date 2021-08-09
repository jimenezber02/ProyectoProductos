<?php
    include("../../conexion/conexion.php");
    include("../productos.php");

    $datos = array(
        $_POST['codigo'],
        $_POST['nombre'],
        $_POST['desc'],
        $_POST['precio'],
        $_POST['categoria']
    );

    $ob = new productos();

    echo($ob -> agregaDat($datos));
?>