<?php
    Class productosPedidosModel{
        private $conexion;
        private $conn;
        private $productos;

        function __construct(){
            require_once "../conexion/conexion.php";
            $this->conexion = new conexion();
            $this->conn = $this->conexion->conectar();
            $this->productos = array();
        }

        public function saveProductos($datos,$idFechaPed){
            $productos = json_decode($datos['productos']);
            $prod = json_encode($productos);

            $sentencia = "INSERT into prod_pedidos (productos,id_ped) values (
                '$prod',
                '$idFechaPed'
            )";

            return mysqli_query($this->conn,$sentencia);
        }

        public function update_productos_pedidos($datos,$idFechaPed){
            $productos = json_decode($datos['productos']);
            $prod = json_encode($productos);

            $query = "UPDATE prod_pedidos SET productos = productos + '$prod' WHERE id_ped = '$idFechaPed' ";
            if(mysqli_query($this->conn,$query)){
                return mysqli_affected_rows($this->conn);
            }
            return -1;
        }

        //elimina los productos que se pidieron en una fecha
        public function delete_product_pedidos($id_fecha){
            $query = "DELETE FROM prod_pedidos WHERE id_ped ='$id_fecha' ";
            if(mysqli_query($this->conn,$query)){
                return mysqli_affected_rows($this->conn);
            }else{
                return -1;
            }
        }

        public function getProductosPedidos($id){
            $sentencia = "SELECT * FROM prod_pedidos WHERE id_ped='$id' ";

            if($r = mysqli_query($this->conn,$sentencia)){
                while ($i = mysqli_fetch_array($r)){
                    $this->productos[] = $i;
                }
                return $this->productos;
            }else{
                return 0;
            }
        }
    }
?>