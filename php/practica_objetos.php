<?php
  $objeto = new ArrayObject();/*
  $objeto -> append(array('arroz','5'));
  $objeto -> append(array('pollo','1'));

  foreach ($objeto as list($nombre,$cant)) {
    // code...
    //print "$key = $value\n";
    echo "$nombre $cant </br>";
  }*/


  /*$objeto -> append(array($_POST['codigo'], $_POST['nombre'],
  $_POST['cantidad'], $_POST['precio'], $_POST['costo'], $_POST['id_tr']));*/

  $i=0;
  $datos = json_decode($_REQUEST["datos"],true);

  //while($i < count($datos)){
    //$arr = '';
    foreach ($datos as $key => $value) {
      # code...
      echo($key2."=>".$value2);
      //$arr = $arr.$value."|"; 
    }
    //echo($arr);
    echo("</br>");
    //$i++;
  //}

?>
