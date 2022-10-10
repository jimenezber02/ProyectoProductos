<?php 
    //include("../conexion/conexion.php");
    include('models/categoriasProductModel.php');

    $categoriasController = new categoriasProductModel();
    $categorias['categorias'] = $categoriasController->getCategorias();
?>