<?php

    Class clienteModel{
        private $objeConexion;
        private $conn;
        private $clientes;

        function __construct(){
            require_once("../conexion/conexion.php");
            $this->objeConexion = new conexion();
            $this->conn = $this->objeConexion->conectar();
            $this->clientes = Array();
        }

        public function getClientes(){
            $sentencia = "SELECT clientes.id_cli,clientes.nombre,clientes.apellido, clientes.cedula,
                            cuentas_p_cobrar.id_cuentxcobrar, cuentas_p_cobrar.cuenta
                            From clientes LEFT join cuentas_p_cobrar
                            ON clientes.id_cli = cuentas_p_cobrar.id_cli";
            $result = mysqli_query($this->conn,$sentencia);
            while($i = mysqli_fetch_array($result))
            {
                $this->clientes[] = $i;
            }
            return $this->clientes;
        }

        public function saveCliente($datos){
            $sentencia = "INSERT into clientes (nombre,apellido,cedula) values ('$datos[nombre]','$datos[apellido]','$datos[cedula]')";

            if(mysqli_query($this->conn,$sentencia)){
                return mysqli_insert_id($this->conn);
            }else{
                return -1;
            }
        }

        public function updateCliente($datos){
            $sentencia = "UPDATE clientes SET nombre = '$datos[nombre]', apellido = '$datos[apellido]',
                    cedula = '$datos[cedula]'WHERE id_cli = '$datos[id]'";

            return mysqli_query($this->conn,$sentencia);
        }


        /*
        public function deleteCliente($id){
            $cliente = new Cliente($id);

        }*/
    }
?>
