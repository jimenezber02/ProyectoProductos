<?php
  /**
    *
  */
  class agregar_cuenta
  {
    private $nc;
    private $cuenta;
    private $pedidos;
    private $id;//almacena cuando se registra un cliente
    private $id_cuenta;//almacena id de la nueva cuentas
    //NOTA: existe una tabla cliente y existe una tabla cuenta que está relacionada al cliente

    function __construct()
    {
      // code...
      require_once("../models/clienteModel.php");
      require_once("../models/cuentaPorCobrarModel.php");
      require_once("../models/fechaPedidosModel.php");
      $this->nc = new clienteModel();
      $this->cuenta = new cuentaPorCobrarModel();
      $this->pedidos = new fechaPedidosModel();
    }

    public function agregar_cliente($data){
      /*la funcion "saveCliente" retorna -1 o el ID del nuevo cliente,
      almacenanos ese para poder usarlo en otra funcion*/
      $this->id = $this->nc->saveCliente($data);

      return $this->id;
    }

    public function salvar_cuenta($monto){
      //retorna -1 o el id de la nueva cuenta agregada
      if($this->id >= 0){//comprueba si registró cliente
        $this->id_cuenta = $this->cuenta->saveCuenta($monto,$this->id);
        return $this->id_cuenta;
      }

      return -1;
    }

    public function salvar_pedido($datos){
      if($datos["monto"] > 0){
        return $this->pedidos->saveFecha($datos,$this->id_cuenta);
      }

      return -1;
    }
  }//FIN DE LA CLASE


  //desde javascript recibe el formulario.serialize()
  //desde el script creditos.js, y va tomando estos datos uno a uno de cada campo del form
  /***************************/
  $data = array(
    "nombre"   => $_POST['inputNombre'],
    "apellido" => $_POST['inputApellido'],
    "cedula"   => $_POST['inputCed'],
    "monto"    => floatval($_POST['monto']),
    "comentario"   => $_POST['comentario'],
    "fecha"    => $_POST['fecha'],
  );

  /*******************/
  $ac = new agregar_cuenta();

  $response = array(
    "tablaCliente" => $ac->agregar_cliente($data),
    "tablaCuenta" => $ac->salvar_cuenta($data["monto"]),
    "tablaPedidos" => $ac->salvar_pedido($data)
  );

  echo json_encode($response);
?>
