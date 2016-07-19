CONFIRMACIÓN DE DATOS

<script type="text/javascript">
	function anterior_medicion()
	{
    	// Se llama la función que contiene los formularios de medición
		medir_obra("descole_fotos", $("#id_medicion").val(), 2);
	}

	// function continuar_medicion()
	// {
	// 	medir_obra("confirmacion");
	// }

	

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se activan los botones
        botones({"volver": true, "guardar": true, "anterior_medicion": true});

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Recolección de datos finalizada", 
    		"Revise los datos y presione el botón Guardar",
    		"announcement"
		]);
	}); // document.ready
</script>