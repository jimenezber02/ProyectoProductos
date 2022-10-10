<?php
    define('FPDF_FONTPATH','fpdf184/font/');
    require("fpdf184/fpdf.php");

    class clasePDF extends FPDF{
        private $titulo;
        private $fecha;

        public function setTitulo($title){
          $this->titulo = $title;
        }

        public function setFecha($fecha){
          $this->fecha = $fecha;
        }

        public function PDF($pdf){
          $pdf = new FPDF('P','mm','Letter');
          $this->SetDrawColor(100,200,210);

          return $pdf;
        }

        public function Footer(){//pie de pagina
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->SetTextColor(0,100,0);
            $this->Cell(188.6/3,10,'Abarroteria.',0,0,'L');
            $this->Cell(188.6/3,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
            $this->Cell(188.6/3,10,'Generado el '.$this->fecha,0,0,'R');
            //
        }

        public function Header(){//encabezado de pagina
            $this->Image('../../img/vender.png',173,5,25);
            $this->SetFont('Arial','B','12');
            //$this->SetFillColor(250,250,250);
            //$this->Cell(80);
            $this->Cell(170,25,$this->titulo,0,0,'C',false);
            $this->ln(15);
        }
    }
?>
