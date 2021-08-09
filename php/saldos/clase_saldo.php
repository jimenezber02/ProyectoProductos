<?php  
	/**
	 * 
	 */
	//include("../conexion/conexion.php");
	//include("../creditos/clase_creditos.php");
	class clase_saldo
	{
		private $conexion;
		private $conn;
		private $objCred;
		function __construct()
		{
			# code...
			$this->conexion = new conexion();
			$this->conn = $this->conexion-> conectar();
		}
	
		public function crea_cuenta($datos){
		//Cuando se crea una cuenta de saldo, se crea una de credito tambien pero con el valor del monto de credito en 0
			$resultado = 0;
			//Inserta los datos en la tabla clientes
			$sentencia = "INSERT into clientes (nombre,apellido,cedula) values(
				'$datos[nombre]',
				'$datos[apellido]',
				'$datos[cedula]'
			)";
			if(mysqli_query($this->conn,$sentencia))
			{//si no hay error

				$datos["idCliente"] = mysqli_insert_id($this->conn);
				$datos["monto"] = 0;//monto para credito
				if($this->inserta_saldo($datos)){//manda insertar en la tabla saldos
					//Manda a crear una cuenta de credito, pero en 0
					//la siguiente función está en la clase_creditos()
					$this->objCred = new clase_creditos();
					$this->objCred-> insertaTablaCuentasPorCobrar($datos);
				}
				$resultado = $datos["idCliente"];
			}

			return $resultado;
		}

		public function inserta_saldo($datos){
			$sentencia = "INSERT into saldos (monto,id_cli) values(
				'$datos[montoSaldo]',
				'$datos[idCliente]'
			)";

			return mysqli_query($this->conn,$sentencia);
		}

		public function deleteCuentaSaldo($idCliente){
			$sentencia = "DELETE FROM saldos WHERE id_cli = '$idCliente' ";

			return mysqli_query($this->conn,$sentencia);
		}

		public function busca_saldo($idCuenta){
			$resultado = 0;
			$sentencia = "SELECT * FROM saldos WHERE id_cli = '$idCuenta' ";
			if(mysqli_query($this->conn,$sentencia)){
				$r = mysqli_query($this->conn,$sentencia);
				$v = mysqli_fetch_row($r);
				$resultado = array("id"=>$v[0],"saldo"=>$v[1]);
			}
			return $resultado;
		}

		public function saldos(){
			$saldos = new ArrayObject();
			$sentencia = "SELECT * FROM saldos";
			$r = mysqli_query($this->conn,$sentencia);
			while($i = mysqli_fetch_array($r)){
				$v = array(
					'id' => $i[0], 
					'saldo' => $i[1], 
					'idCliente' => $i[2]
				);
				$saldos -> append($v);
			}
			return $saldos;
		}

		public function updateCuentaSaldo($datos){
			$resultado = 0;
			$cred = new clase_creditos();
			if($cred-> update_cliente($datos)){
				$sentencia = "UPDATE saldos SET monto = '$datos[saldo]' WHERE id_cli = '$datos[id]' ";
				$resultado = mysqli_query($this->conn,$sentencia);
			}

			return $resultado;
		} 
	}
?>