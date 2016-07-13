CONFIRMACIÓN DE DATOS

<script type="text/javascript">
	function continuar_medicion()
	{
		medir_obra("confirmacion");
	}

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se activan los botones
        botones({"volver": true, "guardar": true});

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Recolección de datos finalizada", 
    		"Revise los datos y presione el botón Guardar",
    		"announcement"
		]);
	}); // document.ready
</script>