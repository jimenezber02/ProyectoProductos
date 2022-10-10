<?php
    require_once("../models/productModel.php");

    $productModel = new productModel();

    echo (json_encode($productModel->findProductById($_POST['idPro'])));
?>