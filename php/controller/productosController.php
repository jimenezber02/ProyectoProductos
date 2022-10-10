<?php 
    require_once('../models/productModel.php');

    $productController = new productModel();
    $productos['productos'] = $productController->getProducts();
?>