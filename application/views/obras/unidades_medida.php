<div class="three fields">
	<?php
	// Se consultan las unidades de medición para el tipo de obra
	$unidades_medida = $this->Configuracion_model->cargar("obras_tipos_unidades_medida", $id_tipo_obra);

	// Contador
	$cont = 1;

	// Se recorren
	foreach ($unidades_medida as $unidad_medida) {
	?>
		<div class="field">
			<label for="input_peso"><?php echo $unidad_medida->Nombre; ?></label>
			<input type="text" id="input_numero_valor_<?php echo $cont++; ?>" data-unidad-medida="<?php echo $unidad_medida->Pk_Id; ?>" value="<?php // if(isset($unidad->Valor)){echo $unidad->Valor;} ?>">
		</div>
	<?php
	} // foreach
	?>
</div>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Campos a bloquear para que sea sólo numérico
        $('input[id^="input_numero_"]').numericInput({
            allowFloat: true, 
            allowNegative: false
        });

        // Se activan los botones
        botones({"listar": true, "guardar": true, "volver": true});
	}); // document.ready
</script>