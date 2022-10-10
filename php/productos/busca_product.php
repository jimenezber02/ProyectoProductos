<?php
    require_once("../models/productModel.php");
    $product = new productModel();

    echo(json_encode($product->findProductById($_POST['idPro'])));
?>