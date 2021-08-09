<?php
    class productos{
        private $obj; 
        private $_conn;
        private $productos;
    
        function __construct(){
            $this->obj = new conexion();
            $this->_conn = $this ->obj ->conectar();
            $this->productos = array();
        }

        public function agregaDat($datos){

            $result = "INSERT into productos (codigo,nombre,descripcion,precio,id_categoria) 
            values ('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]')";

            return mysqli_query($this->_conn,$result);
        }

        //método para editar
        public function buscaProduct($id){
            $sentencia = "SELECT * FROM productos WHERE id = '$id'";

            $result = mysqli_query($this->_conn,$sentencia);
            $v = mysqli_fetch_row($result);

            $datos  = array(
                'id' => $v[0],
                'codigo' => $v[1], 
                'nombre' => $v[2], 
                'descripcion' => $v[3], 
                'precio' => $v[4], 
                'id_categoria' => $v[5]
            );
            return $datos;
        }

        public function editar($datos){
            $sentencia = "UPDATE productos SET codigo='$datos[1]',nombre='$datos[2]',descripcion='$datos[3]',
            precio='$datos[4]',id_categoria='$datos[5]' WHERE id='$datos[0]'";

            return mysqli_query($this->_conn,$sentencia);
        }

        public function eliminar($id){
            $sentencia = "DELETE FROM productos WHERE id='$id'";
            return mysqli_query($this->_conn,$sentencia);
        }

        public function eliminaTodos(){
            $band = 0;
            $sentencia = "SELECT * FROM $this->_tabla";
            $result = mysqli_query($this->_conn,$sentencia);
            while($i = mysqli_fetch_array($result)){
                $band = $this->eliminar($i['id']);
            }
            return $band;
        }

        public function getProductos(){
            $sentencia = "SELECT * FROM productos";
            $result = mysqli_query($this->_conn,$sentencia);
            while($i = mysqli_fetch_array($result)){
                $this->productos[] = $i;
            }
            return $this->productos;
        }
    }
?>