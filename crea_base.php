<?php
	class crea_base{
		private $dbClientes = "clientes";
		private $dbCxc = "cuentas_p_cobrar";

		public function conectar(){
			$conexion = mysqli_connect("localhost","root","");

			return $conexion;
		}
		public function creaDatabase($conexion){
			$baseD = "abarroteria";
			if(!empty($baseD)){
				echo("</br>No existe la base, creando la base...");

				$sentencia = "CREATE DATABASE $baseD";
				if(mysqli_query($conexion,$sentencia)){
					echo("</br>Creado la base $baseD");
				}else{echo("</br>No se pudo crear $baseD");}
			}else{echo("</br>Ya existe la base");}
		}

		public function table_created($conexion){
			$_Nbase = "abarroteria";
			$_tabla1 = "productos";
			$tableD = "SELECT * FROM $_Nbase.$_tabla1";
			if(mysqli_query($conexion,$tableD)==null){
				echo("</br></br>Creando la tabla...");
				$sentencia = "CREATE TABLE $_Nbase.$_tabla1(
					id int(5) NOT NULL AUTO_INCREMENT,
					codigo varchar (30) NOT NULL,
					nombre varchar (20) NOT NULL,
					descripcion varchar (20) NOT NULL,
					precio float (7) NOT NULL,
					id_categoria int (10) NOT NULL,

					PRIMARY KEY(id))";
				if(mysqli_query($conexion,$sentencia)){
					echo("</br>Creado la tabla <strong>product</strong>");
				}else{echo("</br>Error al crear tabla <strong>product</strong>");}
			}else{echo("</br></br>Ya existe la tabla <strong>$_tabla1</strong>");}
		}

		public function tabla_clientes($conexion){
			$_Nbase = "abarroteria";

			$tableD ="SELECT * FROM $_Nbase.$this->dbClientes";
			if(!mysqli_query($conexion,$tableD)){
				echo("</br></br>Creando tabla clientes...");
				$sentencia = "CREATE TABLE $_Nbase.$this->dbClientes(
					id_cli int(20) NOT NULL AUTO_INCREMENT,
					nombre varchar (50) NOT NULL,
					apellido varchar (50) NOT NULL,
					cedula varchar (50),

					CONSTRAINT pk1 PRIMARY KEY(id_cli))";
				if(mysqli_query($conexion,$sentencia)){
					echo("</br>Creado la tabla <strong>$this->dbClientes</strong> correctamente");
				}else{
					echo("</br>No se pudo crear la tabla <strong>$this->dbClientes</strong>");
				}
			}else{
				echo("</br></br>Ya existe la tabla $this->dbClientes");
			}
		}

		public function cuenta_por_cobrar($conexion){
			$_Nbase = "abarroteria";

			$tableD ="SELECT * FROM $_Nbase.$this->dbCxc";
			if(!mysqli_query($conexion,$tableD)){
				echo("</br></br>Creando la tabla <strong>$this->dbCxc</strong>...");
				$sentencia = "CREATE TABLE $_Nbase.$this->dbCxc(
					id_cuentxcobrar int(20) NOT NULL AUTO_INCREMENT,
					cuenta float(20) NOT NULL,
					id_cli int(20) NOT NULL,

					CONSTRAINT pk2 PRIMARY KEY(id_cuentxcobrar),
					CONSTRAINT fk1 FOREIGN KEY(id_cli) REFERENCES $this->dbClientes(id_cli))";
				if(mysqli_query($conexion,$sentencia)){
					echo("</br>Creado la tabla <strong>$this->dbCxc</strong> correctamente");
				}else{
					echo("</br>Error al crear la tabla <strong>$this->dbCxc</strong>");
				}
			}else{
				echo("</br></br>Ya existe la tabla <strong>$this->dbCxc</strong>");
			}
		}
		public function pedidos($conexion){
			$_Nbase = "abarroteria";
			$_tabla1 = "pedidos";
			$tableD ="SELECT * FROM $_Nbase.$_tabla1";
			if(!mysqli_query($conexion,$tableD)){
				echo("</br></br>Creando la tabla <strong>$_tabla1</strong>...");
				$sentencia = "CREATE TABLE $_Nbase.$_tabla1(
					id_ped int(20) NOT NULL AUTO_INCREMENT,
					fecha varchar(20) NOT NULL,
					anio varchar(4),
					mes varchar(10),
					diaS varchar(12),
					dia int(2),
					valor float(20) NOT NULL,
					estado varchar(14) NOT NULL,
					comentario varchar(120),
					id_cuentxcobrar int(20) NOT NULL,

					PRIMARY KEY(id_ped),
					FOREIGN KEY(id_cuentxcobrar) REFERENCES $this->dbCxc(id_cuentxcobrar))";
				if(mysqli_query($conexion,$sentencia)){
					echo("</br>Creado la tabla <strong>$_tabla1</strong> correctamente");
				}else{
					echo("</br>Error al crear la tabla <strong>$_tabla1</strong>");
				}
			}else{
				echo("</br></br>Ya existe la tabla <strong>$_tabla1</strong>");
			}
		}
		public function productos_pedidos($conexion){
			$_Nbase = "abarroteria";
			$_tabla1 = "prod_pedidos";
			$tableD ="SELECT * FROM $_Nbase.$_tabla1";
			if(!mysqli_query($conexion,$tableD)){
				echo("</br></br>Creando la tabla <strong>$_tabla1</strong>...");
				$sentencia = "CREATE TABLE $_Nbase.$_tabla1(
					id int(20) NOT NULL AUTO_INCREMENT,
					producto varchar(30) NOT NULL,
					cantidad int(2),
					precio float(7),
					costo float(7),

					id_ped int(20) NOT NULL,

					PRIMARY KEY(id),
					FOREIGN KEY(id_ped) REFERENCES pedidos(id_ped))";
				if(mysqli_query($conexion,$sentencia)){
					echo("</br>Creado la tabla <strong>$_tabla1</strong> correctamente");
				}else{
					echo("</br>Error al crear la tabla <strong>$_tabla1</strong>");
				}
			}else{
				echo("</br></br>Ya existe la tabla <strong>$_tabla1</strong>");
			}
		}

		public function crea_table_categorias($conexion){
			$_Nbase = "abarroteria";
			$_tabla1 = "categoria_producto";
			$tableD = "SELECT * FROM $_Nbase.$_tabla1";
			if(!mysqli_query($conexion,$tableD)){
				echo("</br></br>Creando la tabla...");
				$sentencia = "CREATE TABLE $_Nbase.$_tabla1(
					id int(5) NOT NULL AUTO_INCREMENT,
					categoria varchar (20) NOT NULL,

					PRIMARY KEY(id))";
				if(mysqli_query($conexion,$sentencia)){
					echo("</br>Creado la tabla <strong>$_tabla1</strong>");
				}else{echo("</br>Error al crear tabla <strong>$_tabla1</strong>");}
			}else{echo("</br></br>Ya existe la tabla <strong>$_tabla1</strong>");}
		}

		public function inserta_tabla_categorias($conexion){
			$_Nbase = "abarroteria";
			$_tabla1 = "categoria_producto";
			$tableD = "SELECT * FROM $_Nbase.$_tabla1";
			if(mysqli_query($conexion,$tableD)){
				$sentencia = "INSERT INTO $_Nbase.$_tabla1 (categoria) VALUES
				('Granos'),
				('cafe'),
				('calzados'),
				('Enlatados'),
				('Galletas'),
				('Confites'),
				('Refrescos'),
				('Carnes'),
				('Detergentes'),
				('Escolar'),
				('Aseo'),
				('Especias'),
				('Pan'),
				('Medicamentos'),
				('Telas'),
				('Harina'),
				('Fideos'),
    			('otros')";
    			if(mysqli_query($conexion,$sentencia)){
    				echo("</br>Agregado datos a la tabla <strong>$_tabla1</strong>");
    			}else{echo("</br>Error al agregar datos a la tabla <strong>$_tabla1</strong>");}
			}
		}

		public function tabla_cuenta_anterior($conexion){
			$baseD = "abarroteria";
			$nameTable = "deuda_anteriores";
			$sentencia = "CREATE TABLE $baseD.$nameTable(
				id int(5) NOT NULL AUTO_INCREMENT,
				monto float(7) NOT NULL,
				id_cuentxcobrar int(20) NOT NULL,

				PRIMARY KEY(id),
				FOREIGN KEY(id_cuentxcobrar) REFERENCES cuentas_p_cobrar(id_cuentxcobrar))";
			if(mysqli_query($conexion,$sentencia)){
				echo("</br>CREADO LA TABLA CUENTA ANTERIOR");
			}else{ echo("</br>No se pudo crear la tabla de cuentas anteriores");}
		}

		public function tabla_bonos_saldos($conexion){
			$baseD = "abarroteria";
			$nameTable = "saldos";
			$sentencia = "CREATE TABLE $baseD.$nameTable(
				id int(5) NOT NULL AUTO_INCREMENT,
				monto float(7),
				id_cli int(20) NOT NULL,

				PRIMARY KEY(id),
				FOREIGN KEY(id_cli) REFERENCES clientes(id_cli)
			)";
			if(mysqli_query($conexion,$sentencia)){
				echo "</br>CREADO LA TABLA DE SALDOS";
			}else{echo "</br>No se pudo crear la tabla de saldos";}
		}
	}

	

	$conn = new crea_base();
	if($conn->conectar() != null){
		echo("Conectado");
		$conn->creaDatabase($conn->conectar());
		$conn->table_created($conn->conectar());
		$conn->crea_table_categorias($conn->conectar());
		$conn->tabla_clientes($conn->conectar());
		$conn->cuenta_por_cobrar($conn->conectar());
		$conn->pedidos($conn->conectar());
		$conn->productos_pedidos($conn->conectar());
		$conn->inserta_tabla_categorias($conn->conectar());
		$conn->tabla_cuenta_anterior($conn->conectar());
		$conn->tabla_bonos_saldos($conn->conectar());
	}else{echo("Error de conexion");}

?>
