<h2 class="ui dividing header center aligned azul">
	Punto de partida
</h2>

<?php
// Se consultan los datos de la foto
$datos_foto = $this->Configuracion_model->cargar("datos_foto", $id);

// Se consulta la obra
$obra = $this->Obras_model->cargar("obras", $id);

// Se almacenan las variables
$url_foto = $datos_foto[0];
$descripcion_foto = $datos_foto[1];
?>

<!-- Input oculto con el id de la obra -->
<input id="id_obra" type="hidden" value="<?php echo $id; ?>">

<div class="ui divided items">
	<div class="item">
		<!-- Foto -->
		<div class="image">
			<img src="<?php echo $url_foto; ?>">
		</div>
		
		<!-- Contenido -->
		<div class="content">
			<a class="header"><?php echo $obra->Punto_Referencia; ?></a>
			<div class="meta">
				<span class="cinema"><b>Abscisa inicial: </b> <?php echo $obra->Abscisa_Inicial; ?></span><br>
				<span class="cinema"><b>Tipo: </b> <?php echo $obra->Tipo; ?></span><br>
				<span class="cinema"><b>Lado: </b> <?php echo $obra->Lado; ?></span><br>
			</div>
			<div class="description">
				<p>Última medición: {definir}</p>
			</div>
			<!-- <div class="extra">
				<div class="ui label">
					<a onClick="javascript:obra_encole()">
						<i class="dashboard icon"></i> Iniciar medición
					</a>
				</div>
			</div> -->
		</div><!-- Contenido -->
	</div>
</div>

<script type="text/javascript">
	/**
	 * Comienza la medición de la obra
	 */
	function iniciar_medicion()
	{
		// Datos de la medición
    	datos = {
    		"Fecha": "<?php echo date('Y-m-d'); ?>",
    		"Hora_Inicial": "<?php echo date('H:i'); ?>",
    		"Fk_Id_Obra": $("#id_obra").val()
    	} // datos
    	// imprimir(datos);

    	// Esta es la primera parte de la medición. Por ello, aquí se crea el registro de la medición de la obra, y posteriormente se irá
    	// agregando los datos
    	medicion = ajax("<?php echo site_url('obras/insertar'); ?>", {"tipo": "medicion", "datos": datos}, "HTML");

    	// Se almacena el id de la medición para que todas las interfaces puedan usarlo
    	$("#id_medicion").val(medicion.respuesta);

    	// Se llama la función que contiene los formularios de medición
    	medir_obra("encole", $("#id_medicion").val());
	} // iniciar_medicion

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se activan los botones
        botones({"medir": true, "anterior": true, "siguiente": true});

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Obra inicial encontrada", 
    		"Verifique los datos de la obra y haga clic en el botón superior para iniciar mediciones.",
    		"announcement"
		]);
	}); // document.ready
</script>