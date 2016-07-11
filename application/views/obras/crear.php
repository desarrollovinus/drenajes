<?php
// Si es edición de norma
if ($id != 0) {
	// Se consultan los datos de la obra
	// $obra = $this->obras_model->cargar("obra", $id);

	// Input oculto
	echo '<input id="id_obra" type="hidden" value="'.$id.'">';
} // if
?>

<!-- <h2 class="ui dividing header center aligned">
	Gestión de obras
</h2> -->

<!-- Formulario -->
<form class="ui form">
	<!-- Título -->
	<h2 class="ui right floated header azul">Datos básicos</h2>
	<div class="ui clearing divider"></div>
	
	<div class="four fields">
		<!-- Unidad funcional -->
		<div class="field">
			<label for="select_unidad_funcional">Unidad Funcional *</label>
			<select id="select_unidad_funcional" class="ui fluid search dropdown">
				<!-- Option vacío -->
				<option value="">Obligatorio</option>

				<!-- Recorrido de las unidades funcionales activas -->
				<?php foreach ($this->Configuracion_model->cargar("unidades_funcionales_activas", NULL) as $unidad_funcional) { ?>
					<option value="<?php echo $unidad_funcional->Pk_Id; ?>"><?php echo $unidad_funcional->Codigo . " - " . $unidad_funcional->Nombre; ?></option>
				<?php } // foreach ?>
			</select>
		</div>

		<!-- Punto de referencia -->
		<div class="field">
			<label for="select_punto_referencia">Punto de referencia *</label>
			<select id="select_punto_referencia" class="ui fluid search dropdown">
				<!-- Option vacío -->
				<option value="">Obligatorio</option>
			</select>
		</div>
		
		<!-- Abscisa inicial -->
		<div class="field">
			<label for="input_numero_abscisa_inicial">Abscisa inicial *</label>
			<input type="text" id="input_numero_abscisa_inicial" value="<?php if(isset($unidad->Abscisa_Inicial)){echo $unidad->Abscisa_Inicial;} ?>" placeholder="Obligatorio">
		</div>
		
		<!-- Abscisa final -->
		<div class="field">
			<label for="input_numero_abscisa_final">Abscisa final *</label>
			<input type="text" id="input_numero_abscisa_final" value="<?php if(isset($unidad->Abscisa_Final)){echo $unidad->Abscisa_Final;} ?>" placeholder="Obligatorio">
		</div>
	</div>

	<!-- Título -->
	<h2 class="ui right floated header azul">Medidas de la obra</h2>
	<div class="ui clearing divider"></div>

	<div class="three fields">
		<!-- Tipo de obra -->
		<div class="field">
			<label for="select_tipo_obra">Tipo de obra *</label>
			<select id="select_tipo_obra" class="ui fluid search dropdown">
				<!-- Option vacío -->
				<option value="">Obligatorio</option>

				<!-- Recorrido de los tipos de obra activos -->
				<?php foreach ($this->Configuracion_model->cargar("obras_tipos", NULL) as $tipo_obra) { ?>
					<option value="<?php echo $tipo_obra->Pk_Id; ?>"><?php echo $tipo_obra->Nombre; ?></option>
				<?php } // foreach ?>
			</select>
		</div>

		<!-- Contenedor para las medidas -->
		<div id="cont_unidades_medida"></div>
	</div>

	<!-- Descripción -->
	<label for="input_descripcion">Descripción</label>
	<div class="three fields">
		<textarea rows="3" id="input_descripcion"><?php if(isset($indicador->Descripcion)){echo $indicador->Descripcion;} ?></textarea>
	</div>
</form>
<!-- Formulario -->

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de los checkboxes
        // $('.ui.checkbox').checkbox();

        // Activación de los selects
        $('select[id^="select_"]').dropdown({
			allowAdditions: true
		}); // dropdown

		// Campos a bloquear para que sea sólo numérico
        $('input[id^="input_numero_"]').numericInput({
            allowFloat: true, 
            allowNegative: false
        });

        // Se activan los botones
        botones({"listar": true, "guardar": true, "volver": true});

        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Gestión de obras", 
    		"Cree y/o edite una obra",
    		"checkmark box"
		]);

		// Al elegir un tipo de obra
		$("#select_tipo_obra").on("change", function(){
			// Se ejecuta la función que carga las unidades de medida para este tipo de obra
			cargar_interfaz("cont_unidades_medida", "<?php echo site_url('obras/cargar_interfaz'); ?>", {"tipo": "unidades_medida_obra_tipo", "id": $(this).val()});
		});

		// Al elegir una unidad funcional
		$("#select_unidad_funcional").on("change", function(){
			//Se resetea el select
    		$("#select_punto_referencia").html('');

			// Si se selecciona un valor
            if($(this).val() !== ""){
            	// Se consultan los puntos de referencia de la unidad funcional
            	puntos_referencia = ajax("<?php echo site_url('configuracion/cargar'); ?>", {"tipo": "puntos_referencia", "id": $(this).val()}, "JSON");

            	// Se rellena el select
            	rellenar_select("select_punto_referencia", puntos_referencia);
            } // if
		});

		// Al digitar el ascisado inicial
		$("#input_numero_abscisa_inicial").on("keyup", function(){
			imprimir("ok")
			// El mismo valor del abscisado inicial se agrega al abscisado final, como apoyo a la digitación
			$("#input_numero_abscisa_final").val($(this).val());
		}); // onkeyup
	}); // document.ready
</script>