<?php
	/**
	 * 
	 */
	require_once("clasePDF.php");
	require_once("../controller/productosController.php");
	class productosPDF
	{
		
		private $pdf;

    	function __construct($date)
		{
			// code...
			$this->pdf = new clasePDF();
			$this->pdf->setTitulo("Listado de productos");
			$this->pdf->setFecha($date);

			$this->pdf->AliasNbPages();
			$this->pdf->AddPage();
			$this->pdf->SetTitle("Datos de productos");
		}

		public function encabezado($array){//encabezado de tabla
			$this->pdf->SetFont('Arial','B','10');
			$this->pdf->SetFillColor(156, 158, 254);


			for($i=0; $i<count($array); $i++){
				$this->pdf->Cell((188.6/5),8,$array[$i],1,0,'C',TRUE);
			}
			$this->pdf->ln();
		}

		public function tablaTodos($productos){
			$this->pdf->SetFillColor(255, 255, 255);
			$s = 0;
			foreach ($productos["productos"] as $key => $value) {
				// code...
				$this->filas_tabla($value);
				$s += $value["precio"];
			}
			$this->pie_tabla($s);
		}


		public function filas_tabla($value){
			$this->pdf->Cell((188.6/5),8,$value['codigo'],1,0,'C',TRUE);
			$this->pdf->Cell((188.6/5),8,$value['nombre'],1,0,'C',TRUE);
			$this->pdf->Cell((188.6/5),8,$value['descripcion'],1,0,'C',TRUE);
			$this->pdf->Cell((188.6/5),8,$value['precio'],1,0,'C',TRUE);
			$this->pdf->Cell((188.6/5),8,$value['itbms'],1,1,'C',TRUE);
		}

		public function pie_tabla($val){
			$this->pdf->SetFillColor(156, 158, 254);
			$this->pdf->Cell((188.6/5),8,"",1,0,'C',TRUE);
			$this->pdf->Cell((188.6/5),8,"",1,0,'C',TRUE);
			$this->pdf->Cell((188.6/5),8,"",1,0,'C',TRUE);
			$this->pdf->Cell((188.6/5),8,"TOTAL",1,0,'C',TRUE);
			$this->pdf->Cell((188.6/5),8,$val,1,1,'C',TRUE);
		}

		public function cierraPdf(){
			$this->pdf->output();
		}
	}
	//encabezado
    $v = array("Codigo","Producto","Descripcion","Precio","Itbms");

    $date = $_REQUEST['date'];

    $pdf = new productosPDF($date);
    $pdf->encabezado($v);

    $pdf->tablaTodos($productos);


    $pdf->cierraPdf();
?>