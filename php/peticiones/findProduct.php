<?php
    require_once("../models/productModel.php");

    $productModel = new productModel();

    echo (json_encode($productModel->findProduct($_POST['productoCodigo'])));
?>