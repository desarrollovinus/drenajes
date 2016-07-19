<?php
// Se define el id del tipo de medición
($tipo_medicion == "encole") ? $tipo = 1 : $tipo = 2 ;

// Se consultan los datos de la foto
$datos_foto = $this->Configuracion_model->cargar("datos_foto_medicion", array("Fk_Id_Medicion" => $id, "Numero" => $numero, "Fk_Id_Foto_Tipo" => $tipo));

// Se almacenan las variables
$url_foto = $datos_foto[0];
$descripcion_foto = $datos_foto[1];
?>

<div class="ui segment">
	<!-- Estilo del input -->
	<label for="archivos" class="ui icon button">
		<i class="file icon"></i> Subir foto
	</label>

	<!-- Título -->
	<h2 class="ui right floated header azul">

		<!-- Input -->
		<input type="file" data-numero="<?php echo $numero; ?>" id="archivos" style="display:none">
		<?php echo $tipo_medicion." - Foto ".$numero; ?>
	</h2>

	<div class="ui clearing divider"></div>

	<p>
		<!-- Foto de la obra -->
		<img class="ui centered medium image" width="420px" src="<?php echo $url_foto; ?>">
	</p>
	
	<p>
		<!-- Descripción -->
		<p class="text-center"><?php echo $descripcion_foto; ?></p>
	</p>
</div>

<script type="text/javascript">
	/**
	 * Interfaz anterior
	 */
	function anterior_medicion()
	{
		// Variables
		var tipo_medicion = "<?php echo $tipo_medicion; ?>";
		var numero = "<?php echo $numero ?>";

		// Si es encole y es número 1
		if (tipo_medicion == "encole" && numero == 1) {
			anterior_tipo = "encole";
			anterior_numero = 2;
		} // if

		// si es encole y es numero 2
		if (tipo_medicion == "encole" && numero == 2) {
			anterior_tipo = "encole_fotos";
			anterior_numero = 1;
		} // if

		// si es descole y es numero 1
		if (tipo_medicion == "descole" && numero == 1) {
			// anterior_tipo = "encole_fotos";
			anterior_tipo = "descole";
			// anterior_numero = 2;
		} // if

		// si es descole y es numero 2
		if (tipo_medicion == "descole" && numero == 2) {
			anterior_tipo = "descole_fotos";
			anterior_numero = 1;
		} // if

		// Si es encole
		if ("<?php echo $tipo_medicion; ?>" == "encole") {
			var numero = parseInt("<?php echo $numero; ?>") + 1;
		}
    	// Se llama la función que contiene los formularios de medición
		medir_obra(anterior_tipo, $("#id_medicion").val(), anterior_numero);
	} // anterior_medicion

	/**
	 * Almacenamiento de datos de la interfaz
	 * y continuación la la siguiente
	 */
	function continuar_medicion()
	{
		// Variables
		var tipo_medicion = "<?php echo $tipo_medicion; ?>";
		var numero = "<?php echo $numero ?>";

		// Si es encole y es número 1
		if (tipo_medicion == "encole" && numero == 1) {
			siguiente_tipo = "encole_fotos";
			siguiente_numero = 2;
		} // if

		// si es encole y es numero 2
		if (tipo_medicion == "encole" && numero == 2) {
			// siguiente_tipo = "descole_fotos";
			// siguiente_numero = 1;
			siguiente_tipo = "descole";
		} // if

		// si es descole y es numero 1
		if (tipo_medicion == "descole" && numero == 1) {
			siguiente_tipo = "descole_fotos";
			siguiente_numero = 2;
		} // if

		// si es descole y es numero 2
		if (tipo_medicion == "descole" && numero == 2) {
			siguiente_tipo = "confirmacion";
			siguiente_numero = null;
		} // if

		// Si es encole
		if ("<?php echo $tipo_medicion; ?>" == "encole") {
			var numero = parseInt("<?php echo $numero; ?>") + 1;
		}
    	// Se llama la función que contiene los formularios de medición
		medir_obra(siguiente_tipo, $("#id_medicion").val(), siguiente_numero);
	} // continuar_medicion
	
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se activan los botones
        botones({"volver": true, "continuar_medicion": true, "anterior_medicion": true});

        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Fotografía " + "<?php echo $numero ?>" + " del encole", 
    		"Tome o suba la foto " + "<?php echo $numero ?>" + " correspondientes al encole de la obra que está midiendo.",
    		"announcement"
		]);

    	// Cuando se elija un archivo para subir
        $("input[type='file']").on("change", function(){
        	// Variables
        	var id_medicion = "<?php echo $id; ?>";
        	var tipo_medicion = "<?php echo $tipo_medicion; ?>";
        	var numero_foto = "<?php echo $numero; ?>";

        	// Se sube la foto
            archivo = ajax_archivos("fotos", "<?php echo site_url('subir/foto_medicion" + "/" + id_medicion + "/" + tipo_medicion + "/" + numero_foto + "'); ?>");
            imprimir(archivo);

	        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	        mostrar_mensaje_pie([
	        	"carga", 
	        	"Subiendo foto...", 
	        	"Subiendo foto y asociándola a la medición de la obra creada. Por favor espere..."
	    	]);

	    	// Si existe la foto
	    	if (archivo == "existe") {
	    		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
				modal([
					"Error", 
					"La foto que intenta subir ya existe. Por favor intente con otra.", 
					"bug"
				]);

				return false;
	    	};

	        // Si se subió correctamente
	        if (archivo) {
	        	// Se pasa a la siguiente medición
	        	continuar_medicion();
	        };
        }); // input change
	}); // document.ready
</script>