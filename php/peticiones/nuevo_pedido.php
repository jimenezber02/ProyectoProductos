<?php
  
    require_once("../models/fechaPedidosModel.php");
    require_once("../models/cuentaPorCobrarModel.php");
    require_once("../models/productosPedidosModel.php");
   

    //Captura por POST
    $data = array(
        "id" => $_POST['idCuentaP'],
        "monto" => $_POST['ped_nuevo'],
        "fecha" => $_POST['fecha'],
        "dia" => $_POST['dia'],
        "mes" => $_POST['mes'],
        "anio" => $_POST['anio'],
        "diaLetra" => $_POST['diaLetra'],
        "productos" => $_POST['productos'],
        "comentario" => $_POST['comentario'],
    );

   
    //Objetos de clases necesarias
    $fp = new fechaPedidosModel();
    $cpc = new cuentaPorCobrarModel();
    $pp = new productosPedidosModel();



    //Edita o suma (en caso de que hoy ya se hizo un pedido)
    //O inserta un nuevo pedido en la tabla pedidos
    $ufp = $fp->updateFechaPedido($data);

    /*Si registra el pedido, actualiza la cuenta del cliente en la tabla cuenta
      Si hay productos para almacenar, tambien se almacena */
    if($ufp >= 0){
        echo($cpc->update_cuenta($data['monto'],$data['id']));
        /*para almacenar los productos pedidos */
        /*if(count(json_decode($data['productos'])) > 0){
          $saveProduct = $pp->saveProductos($data,$response["tablaPedidos"]);
        }*/
    }else{
        echo -1;
    }

?>
