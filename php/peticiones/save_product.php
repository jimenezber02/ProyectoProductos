<?php
    /*Agrega o edita datos dependiendo del id */
    include("../models/productModel.php");

    $datos = array(
        $_POST['id'],
        $_POST['codigo'],
        $_POST['nombre'],
        $_POST['descP'],
        $_POST['precio'],
        $_POST['itbms'],
        $_POST['cate'],
    );

    $ob = new productModel();

    if($datos[0] >= 0){
        echo($ob -> editar($datos));
    }else{
        echo($ob -> agregaDat($datos));
    }

?>