<?php
    include("clasePDF.php");//incluye la clase pdf

    /**
     *
     */
    class desgloseFechasPDF
    {
      private $pdf;

      function __construct($idCliente,$date,$cliente)
      {
        // code...
        $this->pdf = new clasePDF();
        $this->pdf->setTitulo("Listado de pedidos de ".$cliente[0]." ".$cliente[1]." ".$cliente[2]);
        $this->pdf->setFecha($date);

        $this->pdf->AliasNbPages();
        $this->pdf->AddPage();
      }

      public function encabezado($array){//encabezado de tabla
        $this->pdf->SetFont('Arial','B','10');
        $this->pdf->SetFillColor(156, 158, 254);


        for($i=0; $i<count($array); $i++){
          $this->pdf->Cell((188.6/6),8,$array[$i],1,0,'C',TRUE);
        }
        $this->pdf->ln();
      }

      public function tablaTodos($fechas){
        $this->pdf->SetFillColor(255, 255, 255);
        $s = 0;
        foreach ($fechas["fechas"] as $key => $value) {
          // code...
          $this->filas_tabla($value);
          $s += $value["valor"];
        }
        $this->pie_tabla($s);
      }

      public function tablaRecientes($recientes){
        $this->pdf->SetFillColor(255, 255, 255);

        foreach ($recientes["recientes"] as $key => $value) {
          // code...
          $this->filas_tabla($value);
        }
      }

      public function tablaAnteriores($anterior){
        $this->pdf->SetFillColor(255, 255, 255);

        foreach ($anterior["anterior"] as $key => $value) {
          // code...
          $this->filas_tabla($value);
        }
      }

      public function filas_tabla($value){
        $this->pdf->Cell((188.6/6),8,$value['diaS'],1,0,'C',TRUE);
        $this->pdf->Cell((188.6/6),8,$value['dia'],1,0,'C',TRUE);
        $this->pdf->Cell((188.6/6),8,$value['mes'],1,0,'C',TRUE);
        $this->pdf->Cell((188.6/6),8,$value['anio'],1,0,'C',TRUE);
        $this->pdf->Cell((188.6/6),8,$value['estado'],1,0,'C',TRUE);
        $this->pdf->Cell((188.6/6),8,$value['valor'],1,1,'C',TRUE);
      }

      public function pie_tabla($val){
        $this->pdf->SetFillColor(156, 158, 254);
        $this->pdf->Cell((188.6/6),8,"",1,0,'C',TRUE);
        $this->pdf->Cell((188.6/6),8,"",1,0,'C',TRUE);
        $this->pdf->Cell((188.6/6),8,"",1,0,'C',TRUE);
        $this->pdf->Cell((188.6/6),8,"",1,0,'C',TRUE);
        $this->pdf->Cell((188.6/6),8,"TOTAL",1,0,'C',TRUE);
        $this->pdf->Cell((188.6/6),8,$val,1,1,'C',TRUE);
      }

      public function cierraPdf(){
        $this->pdf->output();
      }
    }//Fin de la clase


    /**********************************/
    /*********************************/

    //encabezado
    $v = array("D".chr(237)."a (letra)","D".chr(237)."a","Mes","A".chr(241)."o","Estado","Monto");

    /***Parametro de la URL*****/
    $cond = $_REQUEST['cond'];
    $idCliente = $_REQUEST['idC'];
    $date = $_REQUEST['date'];
    require_once("../controller/desglose_pedidosController.php");
    require_once("../controller/Cuenta_anteriorController.php");
    /***************************/

    $pdf = new desgloseFechasPDF($idCliente,$date,$cuentaAnt);
    $pdf->encabezado($v);

    switch ($cond) {
      case 1:
        // code...
        $pdf->tablaRecientes($recientes);
        break;

      case 2:
        // code...
        $pdf->tablaAnteriores($anterior);
        break;

      default:
        // code...
        $pdf->tablaTodos($fechas);
        break;
    }

    $pdf->cierraPdf();

?>
