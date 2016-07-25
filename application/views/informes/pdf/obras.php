<?php
// Variables temporales
$id_medicion = 1;
$id_unidad_funcional = 5;

$GLOBALS['segmento_inicial'] = 0;
$GLOBALS['segmento_final'] = 12;
$GLOBALS['tamanio_seccion'] = 20; // Dado en metros

$segmento_inicial = $GLOBALS['segmento_inicial'];
$segmento_final = $GLOBALS['segmento_final'];
$tamanio_seccion = $GLOBALS['tamanio_seccion'];

/**
 * Variables globales
 */
$GLOBALS['ancho_total'] = 260;

// Cantidad de secciones
$GLOBALS['cantidad_secciones'] = 1000 / $tamanio_seccion;
$cantidad_secciones = $GLOBALS['cantidad_secciones'];

// Tamaño de las columnas
$GLOBALS['tamanio_columna'] = ($GLOBALS['ancho_total']-10) / $cantidad_secciones;
$tamanio_columna = $GLOBALS['tamanio_columna']; 
$tamanio_celda = 5;

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
	    // Arial bold 15
	    $this->SetFont('Helvetica','B',9);

	    // Logo ANI
	    $this->Cell( 26, 21, $this->Image('./img/logo_ani.png', $this->GetX()+2, $this->GetY()+3, 20.78), 1, 0, 'C', false );

	    // Título 1
	    $this->setX(36);
	    $this->MultiCell(177,7, utf8_decode('PROYECTO CONCESIÓN VÍAS DEL NUS - VINUS'),1,'C');
	    $this->setX(36);
	    $this->MultiCell(177,7, utf8_decode(strtoupper("INFORME DE INVENTARIO DE OBRAS. {$GLOBALS['unidad_funcional']->Codigo} - {$GLOBALS['unidad_funcional']->Nombre}")),1,'C');
	    
	    // Título 2
	    $this->setX(36);
	    $this->Cell(45,7, utf8_decode('Segmento inicial:'),1,0,'C');
	    $this->SetFont('Helvetica','',9);
	    $this->Cell(10,7, utf8_decode($GLOBALS['segmento_inicial']),1,0,'C');
	    $this->SetFont('Helvetica','B',9);
	    $this->Cell(45,7, utf8_decode('Segmento final:'),1,0,'C');
	    $this->SetFont('Helvetica','',9);
	    $this->Cell(10,7, utf8_decode($GLOBALS['segmento_final']),1,0,'C');
	    $this->SetFont('Helvetica','B',9);
	    $this->Cell(45,7, utf8_decode('Tamaño de sección:'),1,0,'C');
	    $this->SetFont('Helvetica','',9);
	    $this->Cell(22,7, utf8_decode($GLOBALS['tamanio_seccion']." metros"),1,0,'C');
	    
	    // Logo Vinus
	    $this->setXY(213,10);
	    $this->Cell( 18, 21, $this->Image('./img/logo_vinus.png', $this->GetX()+2, $this->GetY()+2, 14), 1, 0, 'C', false );

	    // Versión
	    $this->setXY(231,10);
	    $this->Cell(39,7, utf8_decode('Código: F-080'),1,1,'C');
	    $this->setX(231);
	    $this->Cell(39,7, utf8_decode('Versión 1.00'),1,1,'C');
	    $this->setX(231);
	    $this->Cell(39,7, utf8_decode('Fecha: 19/04/2016'),1,0,'C');
		$this->Ln();

	    /**
		 * Encabezado 1
		 */
		$this->SetFont('Helvetica','B',9);
		$this->Cell(10, 10, "Km + ", 0, 0, 'C', 0);
		$this->Cell($GLOBALS['ancho_total'] - 10, 5, "", 0, 0, 'C', 0);
		$this->Ln();

		// Fuente
		$this->SetFont('Helvetica','',6);

		// Posición de X
		$this->setX(20);

		$abscisa = 0;

		// Se reccorren las secciones
		for ($i = 1; $i <= $GLOBALS['cantidad_secciones']; $i++) {
			// Se escribe el valor de la abscisa
			$this->Cell($GLOBALS['tamanio_columna'], 5, number_format($abscisa, 0, "", "."), 0, 0, 'L', 0);

			// Se obtiene el valor de la abscisa
			$abscisa += 1000 / $GLOBALS['cantidad_secciones'];
		} // for

		// Salto de línea
	    $this->Ln();
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

/**
 * [buscar_obra description]
 * @return [type] [description]
 */
function buscar_obra($id_unidad_funcional, $abscisado1, $abscisado2, $objeto){
	// Se consulta la obra y se retorna
	return $objeto->Informes_model->cargar("obras_inventario", array("Id_Unidad_Funcional" => $id_unidad_funcional, "Abscisado1" => $abscisado1, "Abscisado2" => $abscisado2));
} // buscar_obra

// Creación del objeto de la clase heredada
$pdf = new PDF("L", "mm", "Letter");

//Alias para el numero de paginas(numeracion)
$pdf->AliasNbPages();

// Fuente
$pdf->SetFont('Helvetica','',6);

//Anadir pagina
$pdf->AddPage();

/**
 * Cuadro de obras
 */
// Contador
$cont = 1;

// Arreglo de obras
$obras = array();

// Se recorren los segmentos
foreach ($segmentos as $segmento) {
	// Abscisa de inicio
 	$abscisa = $segmento->Numero * 1000;

	// Tamaño de la fila para el número del segmento
	($segmento->Valor > 1000) ? $tamanio_fila = 10 : $tamanio_fila = 5 ;

	// Número del segmento
	$pdf->Cell(10, $tamanio_fila, $segmento->Numero, 1, 0, 'C', 0);
	
	// Recorrido de las secciones
	for ($i = 1; $i <= $cantidad_secciones; $i++) {
		// Se consulta la cantidad de obras que hay entre el abscisado anterior y actual
		$obra = buscar_obra($id_unidad_funcional, $abscisa, ($abscisa + $tamanio_seccion-1), $this);

		// Valor de obra nulo
		$valor = null;

		// Si trae una obra
		if ($obra) {
			// Se almacena el valor
			$valor = $obra->Pk_Id;

			// Se agrega al arreglo
			array_push($obras, $valor);
		} // if

		// Se crea la celda
		$pdf->Cell($tamanio_columna, 5, $valor, 1, 0, 'C', 0);

		// Se obtiene el valor de la abscisa
		$abscisa = $abscisa + (1000 / $cantidad_secciones);
	} // for

	// Si no es el último registro
	if (count($segmentos) != $cont) {
		// Salto de línea
		$pdf->Ln();
	} // if

	// Aumento de contador
	$cont++;
} // foreach segmentos

/**
 * Último segmento
 */
// Si el tamaño del último segmento es mayor a 1000
if ($segmento->Valor > 1000) {
	// Tamaño del segmento
	$tamanio_segmento = 1000;

	// Salto de línea
	$pdf->Ln();
	
	// Ubicación de la primera celda
	$pdf->setX(20);

	// Mientras el tamaño no supere el total del segmento
	while ($tamanio_segmento < $segmento->Valor) {
		// Se aumenta el tamaño
		$tamanio_segmento += $tamanio_seccion;

		// Se obtiene el abscisado actual
		$abscisado_actual = ($abscisa-1000)*10;

		// Se consulta la cantidad de obras que hay entre el abscisado anterior y actual
		$obra = buscar_obra($id_unidad_funcional, $abscisado_actual, ($abscisado_actual + $tamanio_seccion-1), $this);

		// Se consulta la cantidad de obras que hay entre el abscisado anterior y actual
		// $obra = $this->Informes_model->cargar("obras_inventario", array("Id_Unidad_Funcional" => $id_unidad_funcional, "Abscisado1" => $abscisado_actual, "Abscisado2" => ($abscisado_actual + $tamanio_seccion-1)));

		// Si no trae una obra, es nulo
		($obra) ? $valor = $obra->Pk_Id : $valor = null ;

		// Se crea la celda
		$pdf->Cell($tamanio_columna, 5, "P", 1, 0, 'C', 0);
		// $pdf->Cell($tamanio_columna, 5, $abscisado_actual."-".($abscisado_actual + $tamanio_seccion-1), 1, 0, 'C', 0);
		
		// Se obtiene el valor de la abscisa
		$abscisa = ($abscisa + (1000 / $cantidad_secciones));
	} // while
} // if

// Salto de línea
$pdf->Ln(10);

/**
 * Cuadro de obras
 */
// Encabezados
$pdf->SetFont('Helvetica','B',9);
$pdf->Cell(/*$GLOBALS["ancho_total"]*/165, 5, utf8_decode("Cuadro de relación de obras"), 1, 1, 'C', 0);
$pdf->Cell(10, 5, "Nro.", 1, 0, 'C', 0);
$pdf->Cell(40, 5, "Punto de referencia", 1, 0, 'C', 0);
$pdf->Cell(15, 5, "Abscisa", 1, 0, 'C', 0);
$pdf->Cell(20, 5, "Calzada", 1, 0, 'C', 0);
$pdf->Cell(30, 5, "Lado", 1, 0, 'C', 0);
$pdf->Cell(30, 5, "Tipo", 1, 0, 'C', 0);
$pdf->Cell(20, 5, utf8_decode("Área"), 1, 0, 'C', 0);

// Salto de línea
$pdf->Ln();

// Estilo
$pdf->SetFont('Helvetica','',9);

// Se recorren las obras encontradas
for ($i=0; $i < count($obras) ; $i++) {
	// Se consulta la obra
	$dato = $this->Obras_model->cargar("obras", $obras[$i]);
	
	// Datos
	$pdf->Cell(10, 5, $dato->Pk_Id, 1, 0, 'R', 0);
	$pdf->Cell(40, 5, utf8_decode($dato->Punto_Referencia), 1, 0, 'L', 0);
	$pdf->Cell(15, 5, utf8_decode($dato->Abscisa_Inicial), 1, 0, 'R', 0);
	$pdf->Cell(20, 5, utf8_decode($dato->Calzada), 1, 0, 'L', 0);
	$pdf->Cell(30, 5, utf8_decode($dato->Lado), 1, 0, 'L', 0);
	$pdf->Cell(30, 5, utf8_decode($dato->Tipo), 1, 0, 'L', 0);
	$pdf->Cell(20, 5, utf8_decode("dato->Area"), 1, 0, 'R', 0);

	// Salto de línea
	$pdf->Ln();
} // for




// Se exporta el PDF
$pdf->Output("I", "Reporte.pdf");
?>