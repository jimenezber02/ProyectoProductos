<?php
    class conexion{
        private $tabla2="productos";
        private $tablaCliente = "clientes";
        private $tablaCuenta = "cuentas_p_cobrar";
        private $pedidos = "pedidos";
        private $tablaProdPed = "prod_pedidos";

        public function conectar(){
            $conexion = mysqli_connect('localhost','root','','abarroteria');

            return $conexion;
        }
        public function getTabla2(){return $this->tabla2;}

        public function getTablaCliente(){
            return $this->tablaCliente;
        }

        public function getTablaCuenta(){
            return $this->tablaCuenta;
        }

        public function getTablaProdPed(){
            return $this->tablaProdPed;
        }

        public function getPedidos(){
            return $this->pedidos;
        }
    }
    $conn = new conexion();
    if(($conn -> conectar()) == null){
        echo("Error de conexion a la base de datos");
    }
?>