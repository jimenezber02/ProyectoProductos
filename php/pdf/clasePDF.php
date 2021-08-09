<?php 
    define('FPDF_FONTPATH','fpdf181/font/');
    require("fpdf181/fpdf.php");
    include("../conexion/conexion.php");
    include("../productos/productos.php");
    include("../creditos/clase_creditos.php");
    include("../saldos/clase_saldo.php");

    class clasePDF extends FPDF{
        private $_obj;
        private $_conn;
        private $datos;
        private $titulo;
        private $fecha;
        /*
        function __construct($titulo){
            $this->titulo = $titulo;
            $this->productos = array();
        }*/

        public function hoja_pdf($pdf,$titulo,$fecha){//Caracteristicas Hoja pdf
            $this->_obj = new conexion();
            $this->_conn = $this->_obj->conectar();
            $this->titulo = $titulo;
            $this->fecha = $fecha;

            $pdf = new FPDF('P','mm','Letter');
            $this->SetDrawColor(100,200,210);

            return $pdf;
        }
        public function Header(){//encabezado de pagina
            $this->Image('../../img/lgo.png',135,8,25);
            $this->SetFont('Courier','B','10');
            //$this->SetFillColor(250,250,250);
            $this->Cell(80);
            $this->Cell(30,10,$this->titulo,0,0,'C',false);
            $this->ln(20);
        }
        public function tabla_productos($encabezado,$subtitulo){
        //Aquí se extrae los datos de la base datod y se crea la tabla pdf
            $this->encabezado_tabla($encabezado,$subtitulo);
            $prod = new productos();
            $productos["productos"] = $prod-> getProductos();
            
            $this->SetFont('Arial','B','8');
            $this->SetFillColor(210,210,250);
            
            foreach ($productos["productos"] as $key => $value) { 
                $this->Cell((188.6/5),8,$value['codigo'],1,0,'C',TRUE);
                $this->Cell((188.6/5),8,$value['nombre'],1,0,'C',TRUE);
                $this->Cell((188.6/5),8,$value['descripcion'],1,0,'C',TRUE);
                $categoria = $this->busca_categoria($value['id_categoria']);
                $this->Cell((188.6/5),8,$categoria,1,0,'C',TRUE);
                $this->Cell((188.6/5),8,$value['precio'],1,1,'C',TRUE);
            }
        }

        public function tabla_creditos($encabezado,$condicion){
        //Aquí se extrae los datos de la base datod y se crea la tabla pdf
            $this->encabezado_tabla($encabezado,'Clientes y creditos');
            $cre = new clase_creditos();
            $creditos["creditos"] = $cre-> getCreditos();
            
            $this->SetFont('Arial','B','8');
            $this->SetFillColor(175,238,238);
            
            $suma = 0;
            $numCli = 1;
            $cont = 0;
            if($condicion > 0){
                foreach ($creditos["creditos"] as $key => $value) { 
                    if($cont > 0){
                        $this->SetFillColor(0,255,255);
                        $cont--;
                    }else{
                        $this->SetFillColor(175,238,238);
                         $cont++;
                    }
                    $this->Cell((38.6/4),8,$numCli,1,0,'C',TRUE);
                    $this->Cell((188.6/4)-9.65,8,$value['nombre'],1,0,'C',TRUE);
                    $this->Cell((188.6/4),8,$value['apellido'],1,0,'C',TRUE);
                    $this->Cell((188.6/4),8,$value['cedula'],1,0,'C',TRUE);
                    $cuenta = $cre-> getCuenta($value['id_cli']);
                    $suma += $cuenta['cuenta'];
                    $this->Cell((188.6/4),8,$cuenta['cuenta'],1,1,'C',TRUE);
                    $numCli++;
                    
                }
                $this->Cell((188.6/4)*3,8,'Total',1,0,'C',TRUE);
                $this->Cell((188.6/4),8,$suma,1,1,'C',TRUE);
            }else{
                foreach ($creditos["creditos"] as $key => $value) { 
                    $cuenta = $cre-> getCuenta($value['id_cli']);
                    if($cuenta['cuenta'] > 0){
                        if($cont > 0){
                            $this->SetFillColor(0,255,255);
                            $cont--;
                        }else{
                            $this->SetFillColor(175,238,238);
                             $cont++;
                        }
                        $this->Cell((38.6/4),8,$numCli,1,0,'C',TRUE);
                        $this->Cell((188.6/4)-9.65,8,$value['nombre'],1,0,'C',TRUE);
                        $this->Cell((188.6/4),8,$value['apellido'],1,0,'C',TRUE);
                        $this->Cell((188.6/4),8,$value['cedula'],1,0,'C',TRUE);
                        
                        $suma += $cuenta['cuenta'];
                        $this->Cell((188.6/4),8,$cuenta['cuenta'],1,1,'C',TRUE);
                        $numCli++;
                    } 
                }
                $this->SetFillColor(0,250,154);
                $this->Cell((188.6 / 4) * 3,8,'Total',1,0,'C',TRUE);
                $this->Cell((188.6 / 4),8,$suma,1,1,'C',TRUE);
            }
        }

        public function tabla_saldos($encabezado,$condicion){
        //Aquí se extrae los datos de la base datod y se crea la tabla pdf
            $this->encabezado_tabla($encabezado,'Clientes y los saldos');
            $cre = new clase_creditos();
            //Retorna todos los clientes
            $creditos["creditos"] = $cre-> getCreditos();

            $sal = new clase_saldo();
            
            $this->SetFont('Arial','B','8');
            $this->SetFillColor(0,250,154);
            
            $cont = 0;
            if($condicion > 0){
                foreach ($creditos["creditos"] as $key => $value) { 
                    if($cont > 0){
                        $this->SetFillColor(0,255,255);
                        $cont--;
                    }else{
                        $this->SetFillColor(175,238,238);
                        $cont++;
                    }   
                    $this->Cell((188.6/4),8,$value['nombre'],1,0,'C',TRUE);
                    $this->Cell((188.6/4),8,$value['apellido'],1,0,'C',TRUE);
                    $this->Cell((188.6/4),8,$value['cedula'],1,0,'C',TRUE);
                    $cuenta = $sal-> busca_saldo($value['id_cli']);
                    $this->Cell((188.6/4),8,$cuenta['saldo'],1,1,'C',TRUE);

                }
            }else{
                foreach ($creditos["creditos"] as $key => $value) { 
                    $cuenta = $sal-> busca_saldo($value['id_cli']);
                    if($cuenta['saldo'] > 0){
                        if($cont > 0){
                            $this->SetFillColor(0,255,255);
                            $cont--;
                        }else{
                            $this->SetFillColor(173,255,47);
                            $cont++;
                        }   
                        $this->Cell((188.6/4),8,$value['nombre'],1,0,'C',TRUE);
                        $this->Cell((188.6/4),8,$value['apellido'],1,0,'C',TRUE);
                        $this->Cell((188.6/4),8,$value['cedula'],1,0,'C',TRUE);
                        
                        $this->Cell((188.6/4),8,$cuenta['saldo'],1,1,'C',TRUE);
                    } 
                }
            }
        }

        public function tablaCuentaFechas($encabezado,$condicion,$idCliente){
            
            $cre = new clase_creditos();//Objeto de clase credito
            $cli = $cre-> busca_cliente($idCliente);
            $cuentaAnterior = $cre-> retorna_cuenta_anterior($idCliente);
            if($condicion == 'todos'){
                $condicion = 'ANTERIOR';
                $ped['pedidos'] = $cre-> getPed_anteriores($condicion,$idCliente);

                $this->imprimeTablaFechas($encabezado,$ped['pedidos'],'PEDIDOS ANTERIORES',$cli,$cuentaAnterior);
                
                $condicion2 = 'RECIENTE';
                $ped2['pedidos2'] = $cre-> getPed_recientes($condicion2,$idCliente);
                $this->imprimeTablaFechas($encabezado,$ped2['pedidos2'],'PEDIDOS RECIENTES',$cli,$cuentaAnterior);
            }else{
                $ped['pedidos'] = $cre-> getPed_anteriores($condicion,$idCliente);
                $this->imprimeTablaFechas($encabezado,$ped['pedidos'],'Pedidos '.$condicion,$cli,$cuentaAnterior);
            }
        }

        public function imprimeTablaFechas($encabezado,$arreglo,$subtitulo,$cliente,$cuentaAnt){
            $this->SetFont('Arial','B','8');
            $this->SetFillColor(135,206,250);
            $this->Cell((188.6),5,$cliente['nom'],1,1,'C',TRUE);
            if(count($arreglo) > 0){
                //$this->encabezado_tabla($encabezado,$subtitulo);

                $this->SetFont('Arial','B','8');
                $this->SetFillColor(0,250,154);
                $this->Cell((188.6),5,$subtitulo,1,1,'C',TRUE);

                //$this->SetFillColor(0,191,255);
                $datos["datos"] = $encabezado;
                
                for($i = 0; $i < count($encabezado); $i++) {
                    # code...
                    if($i == (count($encabezado)-1)){
                        $this->Cell((500.6/count($encabezado)),5,$encabezado[$i],1,1,'C',TRUE);
                    }else{
                        $this->Cell((110.6/count($encabezado)),5,$encabezado[$i],1,0,'C',TRUE);
                    }
                }

                $this->SetFont('Arial','B','8');
                $this->SetFillColor(255,192,203);
                $suma = 0;
                $cont = 0;
                foreach ($arreglo as $key => $value) {
                    if($cont > 0){
                        $this->SetFillColor(175,238,238);
                        $cont--;
                    }else{
                        $this->SetFillColor(255,192,203);
                        $cont++;
                    }   
                    $this->Cell((110.6/5),5,$value['valor'],1,0,'C',TRUE);
                    $this->Cell((110.6/5),5,$value['dia'],1,0,'C',TRUE);
                    $this->Cell((110.6/5),5,$value['mes'],1,0,'C',TRUE);
                    $this->Cell((110.6/5),5,$value['anio'],1,0,'C',TRUE);
                    $this->Cell((500.6/5),5,$value['comentario'],1,1,'C',TRUE);
                    $suma += $value['valor'];
                }
                $this->SetFillColor(0,250,154);
                $this->Cell((188.6/5)*4,5,'SUMATORIA',1,0,'C',TRUE);
                $this->Cell((188.6/5),5,$suma,1,1,'C',TRUE);
                if($cuentaAnt > 0){
                    $abono = $suma - $cuentaAnt['monto'];
                    if($subtitulo == "PEDIDOS ANTERIORES"){
                        $this->Cell((188.6/5)*4,5,'Menos ABONO',1,0,'C',TRUE);
                        $this->Cell((188.6/5),4,$abono,1,1,'C',TRUE);
                        $this->Cell((188.6/5)*4,5,'TOTAL',1,0,'C',TRUE);
                        $this->Cell((188.6/5),5,$suma - $abono,1,1,'C',TRUE);
                    }
                }
                
                $this->Ln(5);
            }else{
                $this->encabezado_tabla($encabezado,$subtitulo);
                $this->SetFont('Arial','B','6');
                $this->SetFillColor(255,192,203);
                $this->Cell((188.6),5,'NO HAY DATOS',1,1,'C',TRUE);
                $this->Ln(5);
            }
        }

        public function Footer(){//pie de pagina
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->SetTextColor(0,100,0);
            $this->Cell(188.6/3,10,'Abarroteria Mary.',0,0,'L');
            $this->Cell(188.6/3,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
            $this->Cell(188.6/3,10,'Generado el '.$this->fecha,0,0,'R');
            //
        }

        public function encabezado_tabla($data,$subtitulo){//encabezado de tabla

            $this->SetFont('Arial','B','8');
            $this->SetFillColor(0,250,154);
            $this->Cell((188.6),5,$subtitulo,1,1,'C',TRUE);

            //$this->SetFillColor(0,191,255);
            $datos["datos"] = $data;
            
            for($i = 0; $i < count($data); $i++) {
                # code...
                if($i == (count($data)-1)){
                    $this->Cell((188.6/count($data)),5,$data[$i],1,1,'C',TRUE);
                }else{
                    $this->Cell((188.6/count($data)),5,$data[$i],1,0,'C',TRUE);
                }
            }
        }


        public function busca_categoria($id){
            //Conexion a la base de datos
            $sentencia = "SELECT * FROM categoria_producto WHERE id='$id'";
           
            $result = mysqli_query($this->_conn,$sentencia);
            $v = mysqli_fetch_array($result);
    
            return $v[1];
        }
    }
?>