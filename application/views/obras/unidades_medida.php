<div class="three fields">
	<?php
	// Se consultan las unidades de medición para el tipo de obra
	$unidades_medida = $this->Configuracion_model->cargar("obras_tipos_unidades_medida", $id_tipo_obra);

	// Se recorren
	foreach ($unidades_medida as $unidad_medida) {
	?>
		<div class="field">
			<label for="input_peso"><?php echo $unidad_medida->Nombre; ?></label>
			<input type="text" id="input_peso" value="<?php if(isset($unidad->Peso)){echo $unidad->Peso;} ?>">
		</div>
	<?php
	} // foreach
	?>
</div>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
        // Se activan los botones
        botones({"listar": true, "guardar": true, "volver": true});
	}); // document.ready
</script>