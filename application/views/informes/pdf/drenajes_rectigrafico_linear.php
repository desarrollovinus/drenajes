<?php
// Variables temporales
$anio = "2016";
$mes = "07";
$id_unidad_funcional = 5;
$segmento_inicial = 38;
$segmento_final = 39;
// $linear = true;
$linear = false;

/**
 * Variables para la configuración
 */
$ancho_total = 260;
$tamanio_celda = 5;
$numero_secciones = 20; // Cantidad de secciones en que se divide un segmento

// Se consultan los datos de la unidad funcional
$GLOBALS['unidad_funcional'] = $this->Configuracion_model->cargar("unidad_funcional", $id_unidad_funcional);

// Se obtienen los segmentos
$segmentos = $this->Configuracion_model->cargar("segmentos_reporte", array("Unidad_Funcional" => $id_unidad_funcional, "Segmento_Inicial" => $segmento_inicial, "Segmento_Final" => $segmento_final));

/**
 * Clase PDF que contiene encabezado, pie de página
 * y otros
 */
class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
	    // Logo
	    // $this->Image('logo_pb.png',10,8,33);
	    
	    // Arial bold 15
	    $this->SetFont('Helvetica','B',12);

	    // Movernos a la derecha
	    // $this->Cell(80);

	    // Título
	    $this->Cell(260, 5, utf8_decode(strtoupper("INFORME DE MEDICIÓN DRENAJES RECTIGRÁFICO. {$GLOBALS['unidad_funcional']->Codigo} - {$GLOBALS['unidad_funcional']->Nombre}")), 1, 0, 'C');

	    // Salto de línea
	    $this->Ln(20);
	} // Header

	// Pie de página
	function Footer()
	{
	    // Posición: a x mm del final
	    $this->SetY(-15);

	    // Arial italic 8
	    $this->SetFont('Arial','I',8);

	    // Número de página
	    $this->Cell(0, 10, utf8_decode("Concesión Vías del Nus - Sistema de medición de drenajes - Página ".$this->PageNo()." de {nb}"), 0, 0, 'C');
	} // footer
} // PDF



// Creación del objeto de la clase heredada
$pdf = new PDF("L", "mm", "Letter");

//Alias para el numero de paginas(numeracion)
$pdf->AliasNbPages();

// Fuente
$pdf->SetFont('Arial','B',10);

//Anadir pagina
$pdf->AddPage();

// Fuente
$pdf->SetFont('Helvetica','',6);

/**
 * Encabezado 1
 */
$pdf->Cell(10, 10, "Km + ", 1, 0, 'C', 0);
$pdf->Cell($ancho_total-10, 5, "Abscisado", 1, 0, 'C', 0);
$pdf->Ln();

// Posición de X
$pdf->setX(20);

// Valor inicial del abscisado 
$abscisa = 0;

// Si no es linear, la cantidad de secciones se crean en una sola fila 
($linear) ? $cantidad_secciones = $numero_secciones * count($segmentos) : $cantidad_secciones = $numero_secciones ;

// Tamaño de las columnas
$tamanio_columna = ($ancho_total-10) / $cantidad_secciones;

// Contador
$cont = 1;

// Se recorren los segmentos
foreach ($segmentos as $segmento) {
	/**
	 * Encabezado 2
	 */
	// Si es el primer registro
	if ($cont == 1) {
		// Se reccorren las secciones
		for ($i = 1; $i <= $cantidad_secciones; $i++) {
			// Se obtiene el valor de la abscisa
			$abscisa += 1000 / $numero_secciones;

			// Se escribe el valor de la abscisa
			$pdf->Cell($tamanio_columna, 5, number_format($abscisa, 0, "", "."), 1, 0, 'C', 0);
		} // for

		// Salto de línea
		$pdf->Ln();
	} // if

	if ($linear) {
		$tamanio_fila = 5;
	}else if(!$linear && $segmento->Valor > 1000){
		$tamanio_fila = 10;
	}else{
		$tamanio_fila = 5;
	}

	// 
	if ($linear && $cont == 1) {
		$pdf->Cell(10, 5, $segmento->Numero, 1, 0, 'C', 0);
	} // if

	if (!$linear) {
		# code...
		$pdf->Cell(10, $tamanio_fila, $segmento->Numero, 1, 0, 'C', 0);
	}

	/**
	 * Último segmento
	 */
	// Si es linear y es mayor al tamaño normal del segmento
	if ($linear && $segmento->Valor > 1000) {
		$cantidad_secciones = $numero_secciones * 1.9;




		// Se obtiene el valor del restante
		$valor_restante = ($segmento->Valor-1000) / 1000;
		 
		
		$cantidad_secciones = $cantidad_secciones + $valor_restante;
		
		$tamanio_columna = ($ancho_total-10) / $cantidad_secciones;

		// Recorrido de las secciones
		for ($i = 1; $i <= $cantidad_secciones; $i++) {
			// Se crea la celda
			$pdf->Cell($tamanio_columna, 5, "A", 1, 0, 'C', 0);
		} // for
	// Si NO es linear y es mayor al tamaño normal del segmento
	}elseif(!$linear || $cont == 1){
		// Recorrido de las secciones
		for ($i = 1; $i <= $cantidad_secciones; $i++) {
			// Se crea la celda
			$pdf->Cell($tamanio_columna, 5, "Y", 1, 0, 'C', 0);
		} // for

		// Si no es el último registro
		if (count($segmentos) != $cont) {
			// Salto de línea
			$pdf->Ln();
		}
	} // if

	// Si el tamaño del segmento es mayor a 1000
	if ($segmento->Valor > 1000) {
		// Tamaño del segmento
		$tamanio_segmento = 1000;

		// Salto de línea
		$pdf->Ln();
		
		// Ubicación de la primera celda
		$pdf->setX(20);

		// Tamaño de las columnas
		// $tamanio_columna = ($ancho_total-10) / ($secciones-1) + ($segmento->Valor/1000) ;

		// Mientras el tamaño no supere el total del segmento
		while ($tamanio_segmento < $segmento->Valor) {
			// Se crea la celda
			$pdf->Cell($tamanio_columna, 5, "Z", 1, 0, 'C', 0);

			// Se aumenta el tamaño
			$tamanio_segmento += $abscisa/$cantidad_secciones;
		} // while
	} // if

	// Aumento de contador
	$cont++;
} // foreach segmentos


$pdf->Output("I", "Reporte.pdf");
?>