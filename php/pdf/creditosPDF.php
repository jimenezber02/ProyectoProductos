<?php
    include("clasePDF.php");//incluye la clase pdf
    require_once("../controller/clienteController.php");

    /**
     *
     */
    class creditosPDF
    {
      private $pdf;

      function __construct($date)
      {
        // code...
        $this->pdf = new clasePDF();
        $this->pdf->setTitulo("Listado de creditos");
        $this->pdf->setFecha($date);

        $this->pdf->AliasNbPages();
        $this->pdf->AddPage();
        $this->pdf->SetTitle("Datos de cuentas de clientes");
      }

      public function encabezado($array){//encabezado de tabla
        $this->pdf->SetFont('Arial','B','10');
        $this->pdf->SetFillColor(156, 158, 254);


        for($i=0; $i<count($array); $i++){
          $this->pdf->Cell((188.6/4),8,$array[$i],1,0,'C',TRUE);
        }
        $this->pdf->ln();
      }

      public function tablaTodos($clientes){
        $this->pdf->SetFillColor(255, 255, 255);
        $s = 0;
        foreach ($clientes["clientes"] as $key => $value) {
          // code...
          $this->filas_tabla($value);
          $s += $value["cuenta"];
        }
        $this->pie_tabla($s);
      }

      public function deudores($clientes){
        $this->pdf->SetFillColor(255, 255, 255);
        $s = 0;
        foreach ($clientes["clientes"] as $key => $value) {
          // code...
          if($value["cuenta"]>0){
            $this->filas_tabla($value);
            $s += $value["cuenta"];
          }
        }
        $this->pie_tabla($s);
      }

      public function filas_tabla($value){
        $this->pdf->Cell((188.6/4),8,$value['nombre'],1,0,'C',TRUE);
        $this->pdf->Cell((188.6/4),8,$value['apellido'],1,0,'C',TRUE);
        $this->pdf->Cell((188.6/4),8,$value['cedula'],1,0,'C',TRUE);
        $this->pdf->Cell((188.6/4),8,$value['cuenta'],1,1,'C',TRUE);
      }

      public function pie_tabla($val){
        $this->pdf->SetFillColor(156, 158, 254);
        $this->pdf->Cell((188.6/4),8,"",1,0,'C',TRUE);
        $this->pdf->Cell((188.6/4),8,"",1,0,'C',TRUE);
        $this->pdf->Cell((188.6/4),8,"TOTAL",1,0,'C',TRUE);
        $this->pdf->Cell((188.6/4),8,$val,1,1,'C',TRUE);
      }

      public function cierraPdf(){
        $this->pdf->output();
      }
    }//Fin de la clase

    //encabezado
    $v = array("Nombre","Apellido","Cedula","Cuenta");

    $cond = $_REQUEST['cond'];
    $date = $_REQUEST['date'];

    $pdf = new creditosPDF($date);
    $pdf->encabezado($v);

    if($cond > 1){
      $pdf->deudores($clientes);
    }else{
      $pdf->tablaTodos($clientes);
    }

    $pdf->cierraPdf();
?>
