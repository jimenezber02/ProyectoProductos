<?php
  Class productModel{
    private $conn;
    private $products;

    function __construct(){
      require_once("../conexion/conexion.php");
      $this->conn = new conexion();
      $this->products = array();
    }

    public function agregaDat($datos){
      $result = "INSERT into productos (codigo,nombre,descripcion,precio,itbms,stock,id_categoria) 
      values ('$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','0','$datos[6]')";

      return mysqli_query($this->conn->conectar(),$result);
    }

    public function getProducts(){
      $query = "SELECT * FROM productos";
      if($r = mysqli_query($this->conn->conectar(),$query)){
        while($i = mysqli_fetch_array($r)){
          $this->products[] = $i;
        }
        return $this->products;
      }
      return -1;
    }

    public function findProductById($id){
      $sentencia = "SELECT * FROM productos WHERE id='$id' ";
      $producto = "";
      if($r = mysqli_query($this->conn->conectar(),$sentencia)){
        while ($i = mysqli_fetch_array($r)){
          $producto = array(
            "id" => $i['id'],
            "codigo" => $i['codigo'],
            "nombre" => $i['nombre'],
            "cantidad" => 1,
            "precio" => $i['precio'],
            "descripcion" => $i['descripcion'],
            "itbms" => $i['itbms'],
            "id_categoria" => $i['id_categoria']
          );
        }
      }
      return $producto;
    }

    public function findProduct($product){//find by code of product
      //$sentencia = "SELECT * FROM productos WHERE nombre LIKE '$product%'";
      $sentencia = "SELECT * FROM productos WHERE codigo='$product' ";
      $producto = "";
      if($r = mysqli_query($this->conn->conectar(),$sentencia)){
        while ($i = mysqli_fetch_array($r)){
          $producto = array(
            "codigo" => $i['codigo'],
            "nombre" => $i['nombre'],
            "cantidad" => 1,
            "precio" => $i['precio'],
            "costo" => $i['precio'],
          );
        }
      }
      return $producto;
    }

    //método para editar
    public function editar($datos){
        $sentencia = "UPDATE productos SET codigo='$datos[1]',nombre='$datos[2]',descripcion='$datos[3]',
        precio='$datos[4]',itbms='$datos[5]',id_categoria='$datos[6]' WHERE id='$datos[0]'";

        return mysqli_query($this->conn->conectar(),$sentencia);
    }

    public function eliminar($id){
        $sentencia = "DELETE FROM productos WHERE id='$id'";
        return mysqli_query($this->conn->conectar(),$sentencia);
    }

    public function eliminaTodos(){
        $band = 0;
        $sentencia = "SELECT * FROM $this->_tabla";
        $result = mysqli_query($this->conn->conectar(),$sentencia);
        while($i = mysqli_fetch_array($result)){
            $band = $this->eliminar($i['id']);
        }
        return $band;
    }
  }
?>
