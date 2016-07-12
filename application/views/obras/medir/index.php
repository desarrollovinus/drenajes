<!-- Formulario -->
<form class="ui form">
	<h2 class="ui dividing header center aligned azul">
		Seleccione una obra como punto de inicio
	</h2>


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
			<label for="select_abscisa inicial">Abscisa inicial *</label>
			<select id="select_abscisa inicial" class="ui fluid search dropdown">
				<!-- Option vacío -->
				<option value="">Obligatorio</option>
			</select>
		</div>

		<!-- Lado -->
		<div class="field">
			<label for="select_lado">Lado *</label>
			<select id="select_lado" class="ui fluid search dropdown">
				<!-- Option vacío -->
				<option value="">Obligatorio</option>
			</select>
		</div>
	</div>
</form>
<!-- Formulario -->

<!-- Contenedor -->
<div id="cont_medir"></div><!-- Contenedor -->

<script type="text/javascript">
	/**
	 * Función que se activa al presionar el botón crear del menú
	 * @return void 
	 */
	function crear()
	{
		// Se carga la interfaz
		// cargar_interfaz("cont_medir", "<?php echo site_url('obras/cargar_interfaz'); ?>", {"tipo": "index_crear", "id": 0});
	} // crear

	/**
	 * Función que se activa al presionar el botón editar del menú
	 * @return void 
	 */
	function editar()
	{


	} // editar

	/**
	 * Eliminación de registros en base de datos
	 * @param  {string} tipo tipo a eliminar
	 * @return {boolean}      true: exitoso
	 */
	function eliminar(tipo)
	{


	} // eliminar

	/**
	 * Gestiona el registro del formulario vía ajax
	 */
	function guardar()
	{

	} // guardar

	/**
	 * Lista las normas
	 */
	function listar(mensaje = null)
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando información preliminar...", 
        	"Listando los datos para la medición"
    	]);

        // Si trae un mensaje
    	// if (mensaje) {
    		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			// modal([
			// 	"Obra guardada", 
			// 	mensaje, 
			// 	"checkmark circle"
			// ]);
    	// };

    	// Carga de interfaz
		// cargar_interfaz("cont_medir", "<?php echo site_url('obras/cargar_interfaz'); ?>", {"tipo": "medir"});
	} // listar

	/**
	 * Vuelve al anterior formulario
	 */
	function volver()
	{
		// Carga de interfaz
		// cargar_interfaz("cont_normas", "<?php // echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "index"});
	} // volver

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de los selects
        $('select[id^="select_"]').dropdown({
			allowAdditions: true
		}); // dropdown

		// Al elegir una unidad funcional
		$("#select_unidad_funcional").on("change", function(){
			// Se cargan los puntos de referencia
			cargar_puntos_referencia();
		}); // change unidad_funcional

		// Por defecto, cargamos la interfaz de la tabla
		listar();
	}); // document.ready
</script>