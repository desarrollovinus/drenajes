<?php
// Se consulta la medición
$medicion = $this->Obras_model->cargar("medicion", $id);
?>

<h2 class="ui header center aligned azul">
	Obstrucción del descole (centímetros)
	<br>	
	
	<center>
		<div class="ui massive input">
			<input type="number" id="input_numero_descole" placeholder="Digite el valor medido" value="<?php echo $medicion->Descole; ?>" autofocus>
		</div>
	</center>
</h2>


<script type="text/javascript">
	function anterior_medicion()
	{
		// Se llama la función que contiene los formularios de medición
		medir_obra("encole_fotos", $("#id_medicion").val(), 2);
	} // anterior_medicion

	/**
	 * Almacenamiento de datos de la interfaz
	 * y continuación la la siguiente
	 */
	function continuar_medicion()
	{
		// Datos de la medición
    	datos = {
    		"Descole": $("#input_numero_descole").val()
    	} // datos

    	// En esta parte, actualizamos los datos del encole de la medición
    	ajax("<?php echo site_url('obras/actualizar'); ?>", {"tipo": "medicion", "id": $("#id_medicion").val(), "datos": datos}, "HTML");

    	// Se llama la función que contiene los formularios de medición
		medir_obra("descole_fotos", $("#id_medicion").val(), 1);
	} // continuar_medicion

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se activan los botones
        botones({"volver": true, "continuar_medicion": true, "anterior_medicion": true});

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Medición del descole", 
    		"Digite el valor de la altura del descole.",
    		"announcement"
		]);
	}); // document.ready
</script>