<?php
    include("../conexion/conexion.php");
    include("productos.php");

    $obj = new productos();

    echo (json_encode($obj->buscaProduct($_POST['idPro'])));
?>