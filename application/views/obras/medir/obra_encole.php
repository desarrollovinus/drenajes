<h2 class="ui header center aligned azul">
	Encole
	<br>	
	
	<center>
		<div class="ui massive icon input">
			<input type="number" placeholder="Digite el valor medido">
			<i class="dashboard icon"></i>
		</div>
	</center>
</h2>

<script type="text/javascript">
	function continuar_medicion()
	{
		medir_obra("encole_fotos");
	}

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se activan los botones
        botones({"volver": true, "continuar_medicion": true});

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Medición del encole", 
    		"Digite el valor de la altura del encole.",
    		"announcement"
		]);
	}); // document.ready
</script>

