Fotos del encole





<script type="text/javascript">
	function continuar_medicion()
	{
		medir_obra("descole");
	}
	
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se activan los botones
        botones({"volver": true, "continuar_medicion": true});

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Fotografías del encole", 
    		"Tome o suba las fotos correspondientes al encole de la obra que está midiendo.",
    		"announcement"
		]);
	}); // document.ready
</script>