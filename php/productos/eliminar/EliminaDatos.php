<?php
    include("../../conexion/conexion.php");
    include("../productos.php");

    $obj = new productos();

    $id = $_POST['idP'];
    if($id != -1){
        echo($obj-> eliminar($id));
    }else{
        echo($obj-> eliminaTodos());
    }
    
?>