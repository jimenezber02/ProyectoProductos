<?php
	/**
	 * 
	 */
	class categoriasProductModel
	{
		private $conexion;
		private $categorias;

		function __construct()
		{
			// code...
			require_once("conexion/conexion.php");
			$this->conexion = new conexion();
			$this->categorias = array();
		}

		public function getCategorias(){
			$query = "SELECT * FROM categoria_producto";
			if($r = mysqli_query($this->conexion->conectar(),$query)){
				while($i = mysqli_fetch_array($r)){
					$this->categorias[] = $i;
				}
				return $this->categorias;
			}
			return -1;
		}
	}
?>