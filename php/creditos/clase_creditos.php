<?php

//include("../saldos/clase_saldo.php");
Class clase_creditos{
	private $obj_conn;//objeto de la clase conexion
	private $conn;

	private $creditos;//tdos los clientes
	private $cuenta;//la cuenta de un cliente
	private $cuentaAnt;//cuenta anterior de un cliente
	private $objSaldo;//objeto de la clase saldo
	private $ped_anteriores;//todos los pedidos anteriores
	private $ped_recientes;//todos los pedidos recientes
	private $fechas_pedidos;//todos los pedidos
	//private $fechas;

	function __construct(){
		$this->obj_conn = new conexion();//objeto de la clase conexion
		$this->conn = $this->obj_conn -> conectar();//Llama al método de conectar a la base de datos
	
		$this->creditos = array();
		$this->cuenta = -1;
		$this->cuentaAnt = array();
		$this->ped_anteriores = array();
		$this->ped_recientes = array();
		$this->fechas_pedidos = array();
	}

	//PARA CREAR UNA NUEVA CUENTA
	public function abrir_cuenta($datos){//Funcion para abrir cuenta de crédito
		$band = 0;
		$sentencia = "INSERT into clientes (nombre,apellido,cedula) values (
				'$datos[nombre]',
				'$datos[apellido]',
				'$datos[cedula]'
		)";

		if(mysqli_query($this->conn,$sentencia)){
			$datos["idCliente"] = mysqli_insert_id($this->conn);
			if($this->insertaTablaCuentasPorCobrar($datos)){
				$band = mysqli_insert_id($this->conn);
		
				$datos["idCuenta"] = mysqli_insert_id($this->conn);
				$datos["montoSaldo"] = 0;
				$this->objSaldo = new clase_saldo();
				$this->objSaldo ->inserta_saldo($datos);
		
				if($datos["monto"] > 0){//Si el monto es mayor a cero, entonces inserta la fecha en que se hace el pedido
					//Llama a la funcion de insertar la fecha del pedido
					$this->inserta_fecha($datos);
				}
			}
		}else{
			$band = 0;
		}

		return $band;
	}

	public function insertaTablaCuentasPorCobrar($datos){//Agrega una cuenta en la tabla de cuentas por cobrar
		$sentencia2 = "INSERT into cuentas_p_cobrar (cuenta,id_cli) values ('$datos[monto]','$datos[idCliente]')";
		
		return mysqli_query($this->conn,$sentencia2);
	}

	public function inserta_fecha($datos){
	//Para insertar la fecha en que se hace el pedido
		$sentencia = "INSERT into pedidos (fecha,anio,mes,diaS,dia,valor,estado,comentario,id_cuentxcobrar) values (
				'$datos[fecha]',
				'$datos[anio]',
				'$datos[mes]',
				'$datos[diaLetra]',
				'$datos[dia]',
				'$datos[monto]',
				'RECIENTE',
				'$datos[coment]',
				'$datos[idCuenta]'
			)";
		return mysqli_query($this->conn,$sentencia);
	}


	//PARA CUANDO UN CLIENTE PIDE NUEVO CREDITO
	public function nuevo_credito($datos){
		$band = 0; 

		$countChar = strlen($datos["coment"]);
		if($countChar > 0){ //Si alguna fila se afectó
			//Si ninguna fila se afectó, significa que se hace pedido en una nueva fecha
			if($this->inserta_fecha($datos)){
				//Llama a funcion de registrar los productos pedidos
				$this->registra_productos($datos,mysqli_insert_id($this->conn));
				$band = 1;
			}
		}else{
			//Se comprueba si la fecha es igual a una ya registrada
			if($this->pedido_en_la_misma_fecha($datos) > 0){
				$band = 1;
				//Llama a funcion de registrar los productos pedidos
				$this->registra_productos($datos,mysqli_insert_id($this->conn));
			}else{
				//Si ninguna fila se afectó, significa que se hace pedido en una nueva fecha
				if($this->inserta_fecha($datos)){
					//Llama a funcion de registrar los productos pedidos
					$this->registra_productos($datos,mysqli_insert_id($this->conn));
					$band = 1;
				}
			}
		}
		
		if($band == 1){
			//En caso de que se haya registrado datos en la tabla de fechas de pedidos
			$sentencia2 = "UPDATE cuentas_p_cobrar SET cuenta = cuenta + '$datos[monto]' 
							WHERE id_cuentxcobrar = '$datos[idCuenta]' ";
			$band = mysqli_query($this->conn,$sentencia2);
		}

		return $band;
	}

	public function pedido_en_la_misma_fecha($datos){
		//Edita en caso de que la fecha de pedido ya esta registrado y se haga un pedido en la misma fecha
		$sentencia = "UPDATE pedidos SET valor = valor + '$datos[monto]' 
					WHERE fecha = '$datos[fecha]' AND estado='RECIENTE' AND id_cuentxcobrar = '$datos[idCuenta]' ";
		$result = mysqli_query($this->conn,$sentencia);

		return mysqli_affected_rows($this->conn);
	}

	public function registra_productos($data,$id_fecha){
		//Esta funcion registra los productos que se hayan pedido a la tabla "productos pedidos"
		//en la posicon 7 del arreglo datos vienen todos los productos que se pidió
		$band = 0;
		$jsonDat = json_decode($data['datos']);
		$i = 0;

		while($i < count($jsonDat)){
			$arr = '';
			foreach ($jsonDat[$i] as $key => $value) {
				$arr = $arr.$value."|"; 
			}
			$prod = explode('|',$arr);
			
			$sentencia = "INSERT into prod_pedidos (producto,cantidad,precio,costo,id_ped) values (
				'$prod[1]','$prod[2]','$prod[3]','$prod[4]','$id_fecha'
			)";
			$band = mysqli_query($this->conn,$sentencia);
			$i++;
		}
		return $band;
	}

	public function getCreditos(){//Retorna toda la tabla de clientes 
		$sentencia = "SELECT * FROM clientes ORDER BY nombre Asc";
		$result = mysqli_query($this->conn,$sentencia);

		while($i = mysqli_fetch_array($result)){
			$this->creditos[] = $i;
		}
		
		return $this->creditos;
	}

	public function getCuenta($id){//Retorna una cuenta a través de un id de cliente
		$sentencia = "SELECT * FROM cuentas_p_cobrar WHERE id_cli = '$id' ";
		$resultado = mysqli_query($this->conn,$sentencia);
		while($i = mysqli_fetch_array($resultado)){
			$this->cuenta = $i;
		}
		return $this->cuenta;
	}

	public function busca_cliente($Elid){
		$sentencia = "SELECT * FROM clientes WHERE id_cli='$Elid'";
		$result = mysqli_query($this->conn,$sentencia);
		$v = mysqli_fetch_row($result);

		$datos = array("id" => $v[0], "nom" => $v[1], "apellido" => $v[2], "ced" => $v[3]);

		return $datos;
	}

	public function busca_producto($codigo){
		$sentencia = "SELECT * FROM productos WHERE codigo='$codigo'";
		$r = mysqli_query($this->conn,$sentencia);
		$dat = "";
		if(mysqli_query($this->conn,$sentencia))
		{
			while($v = mysqli_fetch_array($r)){
				$dat = array("cod"=>$v[1],
						"nombre"=>$v[2],
						"precio"=>$v[4],
						"cantidad" => 1,
						"costo" => $v[4]
				);
			}
		}
		return $dat;
	}

	public function elimina_cliente($id){
		if($this->delete_cuenta($id)){
			$saldos = new clase_saldo();
			if($saldos-> deleteCuentaSaldo($id)){
				$sentencia = "DELETE FROM clientes WHERE id_cli = '$id'";
				return mysqli_query($this->conn,$sentencia);
			}else{return 0;}
		}
	}

	public function delete_cuenta($id){
		$band = $this->delete_pedido($id);
		$this->delete_cuenta_anterior($id);

		$sentencia = "DELETE FROM cuentas_p_cobrar WHERE id_cli = '$id'";
		return mysqli_query($this->conn,$sentencia);
	}

	public function delete_cuenta_anterior($id){
		$sentencia = "DELETE FROM deuda_anteriores WHERE id_cuentxcobrar = '$id' ";
		return mysqli_query($this->conn,$sentencia); 
	}
	public function eliminaFechaAnterior($idCuenta){
		$sentencia = "DELETE FROM pedidos WHERE id_cuentxcobrar = '$idCuenta' AND estado='ANTERIOR' ";
		
		return mysqli_query($this->conn,$sentencia);
	}

	public function delete_pedido($id){
		$band = 0;
		$this->delete_cuenta_anterior($id);
		$sentencia = "SELECT * FROM pedidos WHERE id_cuentxcobrar = '$id'";
		$result = mysqli_query($this->conn,$sentencia);
		if(mysqli_query($this->conn,$sentencia) != null){
				while($i = mysqli_fetch_array($result)){
						$band = $this->delete_productos($i[0]);
					}
		}
		$sentencia2 = "DELETE FROM pedidos WHERE id_cuentxcobrar = '$id'";
		return mysqli_query($this->conn,$sentencia2);
	}

	public function delete_productos($id){
		$sentencia = "DELETE FROM prod_pedidos WHERE id_ped = '$id'";
		return mysqli_query($this->conn,$sentencia);
	}

	public function update_cliente($datos){
		$sentencia = "UPDATE clientes SET nombre = '$datos[nombre]', 
					apellido = '$datos[apellido]', cedula = '$datos[cedula]'
		WHERE id_cli = '$datos[id]'";

		return mysqli_query($this->conn,$sentencia);
	}

	//SEGMENTO DE DESGLOSE DE FECHAS
	public function tabla_fechas($id_cuenta){
		$sentencia = "SELECT * FROM pedidos WHERE id_cuentxcobrar= '$id_cuenta' AND estado = 'RECIENTE' ";
		$resultado = mysqli_query($this->conn,$sentencia);

		while($i = mysqli_fetch_array($resultado)){
			$this->fechas_pedidos[] = $i;
		}
		return $this->fechas_pedidos;
	}

	public function pagaUnaFecha($idFecha){
		$this-> delete_productos($idFecha);
		$sentencia = "DELETE FROM pedidos WHERE id_ped = '$idFecha'";
		
		return mysqli_query($this->conn,$sentencia);
	}

	public function pagaTodaLaCuenta($idCliente,$monto){
		$this->delete_cuenta_anterior($idCliente);
		if($this->delete_pedido($idCliente) > 0){
			$sentencia = "UPDATE cuentas_p_cobrar SET cuenta = 0 WHERE id_cuentxcobrar = '$idCliente' ";
			if(mysqli_query($this->conn,$sentencia)){
				return 1;
			}
			else{
				return -1;
			}
		}else{
			return 0;
		}
	}

	public function retorna_cuenta_anterior($id_cuenta){
		$sentencia = "SELECT * FROM deuda_anteriores WHERE id_cuentxcobrar = '$id_cuenta' ";
		$resultado = mysqli_query($this->conn,$sentencia);
		
		while ($i = mysqli_fetch_array($resultado)) {
			$this->cuentaAnt = $i;
		}
		if(count($this->cuentaAnt) > 0){
			return $this->cuentaAnt;
		}else{
			return -1;
		}
		
	}

	public function getPed_anteriores($cond,$idCuenta){
		$sentencia = "SELECT * FROM pedidos WHERE estado = '$cond' AND id_cuentxcobrar = '$idCuenta'";

		$resultado = mysqli_query($this->conn,$sentencia);
		
		while($i = mysqli_fetch_array($resultado)){
			$this->ped_anteriores[] = $i;
		}
		return $this->ped_anteriores;
	}

	

	public function getPed_recientes($cond,$idCuenta){
		$sentencia = "SELECT * FROM pedidos WHERE estado = '$cond' AND id_cuentxcobrar = '$idCuenta'";

		$resultado = mysqli_query($this->conn,$sentencia);
		while($i = mysqli_fetch_array($resultado)){
			$this->ped_recientes[] = $i;
		}

		return $this->ped_recientes;
	}

	//SEGMENTO DE ABONO
	public function actualiza_fechas($id_cuenta){
		$sentencia = "UPDATE pedidos set estado = 'ANTERIOR' WHERE id_cuentxcobrar = '$id_cuenta'";
		
		return mysqli_query($this->conn, $sentencia);
	}

	public function agrega_abono($id_cuenta){
		$band = 0;
		$sentencia = "SELECT * FROM cuentas_p_cobrar WHERE id_cuentxcobrar = '$id_cuenta' AND cuenta > 0";
		if(mysqli_query($this->conn,$sentencia)){
			$v = mysqli_fetch_row(mysqli_query($this->conn,$sentencia));
			if($v[1] > 0){
				//primero intenta actualizar la deuda anterior en caso de que exista
				$proceso = $this->actualiza_deuda_anterior($id_cuenta,$v[1]);
				if( $proceso  < 1){//Si no se edita, o no existe una deuda anterior, entonces, inserta una nueva
					$sentencia2 = "INSERT into deuda_anteriores (monto,id_cuentxcobrar) 
					values ('$v[1]','$id_cuenta')";
					$band       = mysqli_query($this->conn,$sentencia2);
				}else{$band   = $proceso;}
			}
		}
		
		return $band;
	}

	public function actualiza_deuda_anterior($id_cuenta,$valor){
		$sentencia = "UPDATE deuda_anteriores SET monto = '$valor' WHERE id_cuentxcobrar = '$id_cuenta' ";
		$resultado = mysqli_query($this->conn,$sentencia);
		
		return mysqli_affected_rows($this->conn);
	}

	public function descuenta_abono($monto,$id_cuenta){
		$monto = $monto * 1000;
		$sentencia = "UPDATE cuentas_p_cobrar set cuenta= ((cuenta*1000) - '$monto')/1000 
					WHERE id_cuentxcobrar = '$id_cuenta' ";
		
		return mysqli_query($this->conn,$sentencia);
	}
}
?>
