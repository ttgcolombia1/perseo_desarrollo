<?php 

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}



require('plugin/fpdf/fpdf.php');
include('mensajeActas.php');
include_once("core/manager/Configurador.class.php");

class PDF extends FPDF
{
	var $url;
	var $urlImagen;
	var $parrafo;
	var $noLimpiar;
	
	// Cabecera de página
	function Header()
	{
		/******************************************************/
		// Salto de línea
		$this->Ln(1);
		// Logo
		//$this->Image($this->urlImagen.'escudo.jpg',100,10,-500);
		//$this->Image($this->urlImagen.'oas_logo.jpg',180,260,-800);
		// Arial bold 15
		/******************************************************/
		// Salto de línea
		$this->Ln(5);
		$this->SetFont('Arial','B',14);
		$this->SetFillColor(240,240,240);
		$this->Cell(50);
		$this->Cell(90,20,'UNIVERSIDAD DISTRITAL ',0,0,'C');
		/******************************************************/
		// Salto de línea
		$this->Ln(1);
		$this->SetFont('Arial','B',14);
		$this->SetFillColor(240,240,240);
		// Movernos a la derecha
		$this->Cell(50);
		// Título
		$this->Cell(90,30,'FRANCISCO JOSE DE CALDAS',0,0,'C');
		/******************************************************/
		$year = "AÑOS";
		$this->Ln(1);
		$this->SetFont('Arial','B',8);
		$this->SetFillColor(240,240,240);
		$this->Cell(50);
		$this->Cell(90,40,'(1948-2013)SESENTA Y CINCO '.utf8_decode($year).' DE VIDA UNIVERSITARIA',0,0,'C');
		/******************************************************/
		$this->Ln(1);
		$this->SetFont('Arial','B',8);
		$this->SetFillColor(240,240,240);
		$this->Cell(50);
		$this->Cell(90,50,'SECRETARIA GENERAL',0,0,'C');
		
		
		
	}
	
	function cuerpoActa(){
		
		//El objeto de la clase Configurador debe ser único en toda la aplicación
		$this->miConfigurador=Configurador::singleton();
		$this->sql = new SqlregistroCierreProceso();
		
		$conexion = "estructura";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
		if (!$esteRecursoDB) {
			//Este se considera un error fatal
			exit;
		}
		
		$cadena_sql = $this->sql->cadena_sql('candidatosNombres');
		$resultadoNombres=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
		
		$this->AliasNbPages();
		$this->AddPage();
		
		/******************************************************/
		$this->Ln(10);
		$this->SetFont('Arial','B',12);
		$this->SetFillColor(240,240,240);
		$this->Cell(50);
		$this->Cell(90,50,'NOMBRE:____________________________ FIRMA:_____________',0,0,'C');
		/******************************************************/
		$this->Ln(5);
		$this->SetFont('Arial','I',14);
		$this->Cell(50);
		$this->Cell(90,60,'ACTA DE CIERRE',0,0,'C');
		/******************************************************/
		$this->Ln(5);
		$this->SetFont('Arial','B',12);
		$this->Cell(50);
		$this->Cell(90,70,utf8_decode('ELECCIÓN DEL REPRESENTANTE DE LOS EGRESADOS Y SU SUPLENTE'),0,0,'C');
		/******************************************************/
		//$eleccion = 'ELECCIÓN';
		$this->Ln(1);
		$this->SetFont('Arial','B',12);
		$this->Cell(50);
		$this->Cell(90,80,utf8_decode('ANTE EL CONSEJO SUPERIOR UNIVERSITARIO DE LA UNIVERSIDAD'),0,0,'C');
		/******************************************************/
		
		$this->Ln(1);
		$this->SetFont('Arial','B',12);
		$this->Cell(50);
		$this->Cell(90,90,utf8_decode('DISTRITAL FRANCISCO JOSE DE CALDAS.'),0,0,'C');
		
		/******************************************************/
		$this->Ln(3);
		
		$this->SetFont('Times','',12);
		/****************************************************************************************/
		$y=90;
		$this->SetXY(30, $y);
		$this->Multicell(150,8,strftime("%d de %B del %Y"),0,'C');
		
		/**
		 * Primer Parrafo
		 */
		
		$y=$this->getY();
		if($y>200){
			$this->AddPage();
			$y=90;
		}
		$this->SetXY(30, $y+=0);
		$mensaje='';
		if(!isset($this->noLimpiar[$this->parrafo[0]])){
			$mensaje.=utf8_decode(str_replace (array("\r\n", "\n", "\r"), '', $this->parrafo[0]));
		}else{
			$mensaje.=utf8_decode($this->parrafo[0]);
		}
		$this->Multicell(150,8,$mensaje,0,'J');
		
		/******************************************************/
		$this->Ln(1);
		$this->SetFont('Arial','B',12);
		$this->Cell(50);
		$this->Cell(90,10,utf8_decode('CANDIDATOS ELECCIÓN DEL REPRESENTANTE DE LOS EGRESADOS'),0,0,'C');
		/******************************************************/
		//$eleccion = 'ELECCIÓN';
		$this->Ln(1);
		$this->SetFont('Arial','B',12);
		$this->Cell(50);
		$this->Cell(90,20,utf8_decode('ANTE EL CONSEJO SUPERIOR UNIVERSITARIO DE LA UNIVERSIDAD'),0,0,'C');
		/******************************************************/
		
		$this->Ln(1);
		$this->SetFont('Arial','B',12);
		$this->Cell(50);
		$this->Cell(90,30,utf8_decode('DISTRITAL FRANCISCO JOSE DE CALDAS.'),0,0,'C');
		
		$this->Ln(20);
		//Colores, ancho de línea y fuente en negrita
		$this->SetFillColor(200,200,200);
		$this->SetTextColor(71	);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');
		//Cabecera
		$header = array('APELLIDOS Y NOMBRES', 'TARJETÓN', 'VOTOS'	);
		$w = array(90,35,25);
		
		$this->Cell(20);
		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],10,utf8_decode($header[$i]),1,0,'C',1);
		$this->Ln();
		//Restauración de colores y fuentes
		$this->SetFillColor(240,240,240);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',8);
		//Datos
		$fill=false;
		$totales = 0;
		for($i=0;$i<count($resultadoNombres);$i++)
		{
			
				$cadena_sql = $this->sql->cadena_sql('resultadosPorPlancha',$resultadoNombres[$i][1]);
				$resultadoResultados=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
				
				if($resultadoResultados)
				{
					$total = $resultadoResultados[0][1];
					$totales += $total;
				}else
				{
					$total = 0;
				}
				$mensaje = $resultadoNombres[$i][0].'     '.$resultadoNombres[$i][1].'        '.$total.'  ';
				
				
				
				$this->Cell(20);
				$this->Cell(90,10,utf8_decode($resultadoNombres[$i][0]),'LR',0,'L',$fill);
				
				$this->Cell(35,10,utf8_decode($resultadoNombres[$i][1]),'LR',0,'L',$fill);
				
				$this->Cell(25,10,utf8_decode($total),'LR',0,'L',$fill);
				$this->Ln(5);
		}
		$this->Ln(5);
		$this->SetFillColor(200,200,200);
		$this->SetTextColor(71);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B',14);
		$this->Cell(20);
		$this->Cell(90,10,utf8_decode('TOTAL VOTOS'),'LR',0,'L',1);
		
		$this->Cell(60,10,utf8_decode($totales),'LR',0,'C',1);
		$this->Ln(5);
		
		/**
		 * Texto final
		 */
		$this->SetFont('Times','',12); 
		for($j=1;$j<count($this->parrafo);$j++)
		{
			$y=$this->getY();
			if($y>200){
				$this->AddPage();
				$y=45;
			}
			$this->SetXY(30, $y+=5);
			$mensaje='';
			if(!isset($this->noLimpiar[$this->parrafo[$j]])){
				$mensaje.=utf8_decode(str_replace (array("\r\n", "\n", "\r"), '', $this->parrafo[$j]));
			}else{
				$mensaje.=utf8_decode($this->parrafo[$j]);
			}
			$this->Multicell(150,8,$mensaje,0,'J');
		} 
		
		
		
		
	}

}

// Creación del objeto de la clase heredada
$pdf = new PDF();

$pdf->url = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."documentos";
$pdf->urlImagen = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."imagen/";

$pdf->parrafo=$parrafo;
//$pdf->noLimpiar=$noLimpiar;
$pdf->cuerpoActa();
$pdf->Output();
?>