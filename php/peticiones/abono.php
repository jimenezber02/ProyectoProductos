<?php
    require_once("../models/fechaPedidosModel.php");
    require_once("../models/cuentaPorCobrarModel.php");

    $data = array(
      "idCliente" => $_POST['idCliente'],
      "idCuenta" => $_POST['idCuenta'],
      "cuenta" => $_POST['cuenta'],
      "elabono" => $_POST['elabono'],
      "accion" => $_POST['accion']
    );

    $response = array();

    $cpc = new cuentaPorCobrarModel();
    $fp = new fechaPedidosModel();

    //Edita la cuenta del cliente
    $response['tabla_cuenta'] = $cpc->setCuenta($data['cuenta'],$data['idCliente']);
    if($response['tabla_cuenta'] > 0){
        //***** La acción 1 indica: para abonar una parte de la deuda  o 2 si se va a cancelar la deuda ****//
        if((intval($data['accion']) == 2) || (floatval($data['cuenta']) == floatval($data['elabono']))){
            //Elimina todos los pedidos y si tiene productos pedidos, tambien se borra
          $fp->delete_fecha_pedidos_and_productos_pedidos($data['idCuenta']);
          $fp->delete_pedidos($data['idCuenta']);
        }else {
          $fp->set_status_pedido($data['idCuenta']);
        }
    }
    echo json_encode($response);
?>
