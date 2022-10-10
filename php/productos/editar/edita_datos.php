<?php
    include("../../conexion/conexion.php");
    include("../productos.php");

    $obj = new productos();
    $datos = array(
        $_POST['id'],
        $_POST['codigo'],
        $_POST['nombre'],
        $_POST['descP'],
        $_POST['precio'],
        $_POST['itbms'],
        $_POST['cate']
    );

    echo($obj->editar($datos));
?>