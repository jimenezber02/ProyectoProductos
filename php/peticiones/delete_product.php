
<?php
	require_once("../models/productModel.php");

    $obj = new productModel();

    echo($obj-> eliminar($_POST['idP']));
?>