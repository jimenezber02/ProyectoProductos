<?php
    include("clasePDF.php");//incluye la clase pdf

//$this->_pdf->Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]]);
    //              ancho|alto|cadena|border(1,0)|posicion de valor actual|align|fondo(true,false)
    class generaPDF{
        private $_pdf;
        private $data = array("Nombre","Apellido","Cedula","Saldo");

        function __construct($condicion,$date){
            $this->_pdf = new clasePDF();//objeto de la clase pdf
            //llama a los metodos de la clase pdf
            $this->_pdf ->hoja_pdf($this->_pdf,"SALDOS",$date);
            $this->_pdf ->AliasNbPages();
            $this->_pdf ->AddPage();
            $this->_pdf ->tabla_saldos($this->data,$condicion);
        }

        public function cierra_pdf(){
            $this->_pdf->output();
        }
    }
    $cond = $_REQUEST['cond'];
    $date = $_REQUEST['date'];
    $obj = new generaPDF($cond,$date);
    $obj->cierra_pdf();
?>