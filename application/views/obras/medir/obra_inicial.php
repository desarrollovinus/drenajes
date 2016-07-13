<h2 class="ui dividing header center aligned azul">
	Obra inicial
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

<div class="ui divided items ">
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
			<div class="extra">
				<!-- <div class="ui label">IMAX</div> -->
				<div class="ui label">
					<a onClick="javascript:obra_encole()">
						<i class="dashboard icon"></i> Iniciar medición
					</a>
				</div>
			</div>
		</div><!-- Contenido -->
	</div>

	<!-- <div class="extra">
		<div class="ui right floated primary button" id="btn_derecha" onClick="javascript:siguiente('derecha', '<?php // echo $id; ?>')">
			Derecha
			<i class="right chevron icon"></i>
		</div>
	
		<div class="ui left floated primary button" onClick="javascript:siguiente('izquierda', '<?php // echo $id; ?>')">
			<i class="left chevron icon"></i>
			Izquierda
		</div>
	</div> -->
</div>

<script type="text/javascript">
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