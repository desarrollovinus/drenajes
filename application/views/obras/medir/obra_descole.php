Descole


<script type="text/javascript">
	function continuar_medicion()
	{
		medir_obra("descole_fotos");
	}
	
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se activan los botones
        botones({"volver": true, "continuar_medicion": true});

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Medición del descole", 
    		"Digite el valor de la altura del descole.",
    		"announcement"
		]);
	}); // document.ready
</script>