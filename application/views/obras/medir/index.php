<!-- Formulario -->
<form class="ui form">
	<h2 class="ui dividing header center aligned azul">
		Seleccione una obra como punto de inicio
	</h2>

	<div class="two fields">
		<!-- Abscisa inicial -->
		<div class="field">
			<label for="select_abscisa_inicial">Abscisa inicial (ms)*</label>
			<select id="select_abscisa_inicial" class="ui fluid search dropdown">
				<!-- Option vacío -->
				<option value="">Obligatorio</option>

				<!-- Recorrido de las abscisas iniciales de las obras -->
				<?php foreach ($this->Obras_model->cargar("abscisas_iniciales_obras", NULL) as $abscisa) { ?>
					<option value="<?php echo $abscisa->Abscisa_Inicial; ?>"><?php echo $abscisa->Abscisa_Inicial; ?></option>
				<?php } // foreach ?>
			</select>
		</div>

		<!-- Lado -->
		<div class="field">
			<label for="select_lado">Lado *</label>
			<select id="select_lado" class="ui fluid search dropdown">
				<!-- Option vacío -->
				<option value="">Obligatorio</option>

				<!-- Recorrido de los lados -->
				<?php foreach ($this->Configuracion_model->cargar("lados", NULL) as $lado) { ?>
					<option value="<?php echo $lado->Pk_Id; ?>" data-codigo-lado="<?php echo $lado->Codigo; ?>"><?php echo $lado->Nombre; ?></option>
				<?php } // foreach ?>
			</select>
		</div>
	</div>
</form>
<!-- Formulario -->

<div class="ui divider"></div>

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
	 * Función que elige la siguiente obra y la carga
	 * @param  {string} sentido Derecha o izquierda (ascendente o descendiente)
	 */
	function siguiente(sentido)
	{
		// Id de la obra
		var id_obra = $("#id_obra").val();

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando siguiente obra...", 
        	"Generando los datos de la siguente obra a la " + sentido + "."
    	]);

    	// Se consultan los id de las obras 
    	obras = ajax("<?php echo site_url('obras/cargar'); ?>", {"tipo": "obras_id"}, "JSON");

    	// Arreglo de las obras
    	var obras = obras.respuesta;
    	var id_obra_siguiente, id_obra_anterior;

		// Se recorre el arreglo
		for (var i = 0; i < obras.length; i++) {
			// Si el valor de la posición es el valor buscado
		    if (obras[i].Pk_Id === id_obra) {
		    	// Si el sentido es a la derecha
		    	if (sentido == "derecha") {
		    		// Se sube una posición
		    		var aumento = i + 1;
		    	} else {
		    		// Se baja una posición
		    		var aumento = i - 1;
		    	} // if

		    	/**
		    	 * 
		    	 * 
		    	 * 
		    	 */
		    	if (i < 1) {
		    		// 
		    		id_obra_anterior = null;
		    	}else{
		    		// 
		      		id_obra_siguiente = obras[aumento].Pk_Id;
		    	} // if
		    } // if
	  	} // for
  		
  	// 	// Si se llega al último registro
   //  	if(aumento == obras.length-1){
   //  		imprimir("ultimo")
		 //    		id_obra_siguiente = null;

    		
   //  	} // if

   //  	if (!id_obra_siguiente || !id_obra_anterior) {
   //  		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			// modal([
			// 	"Fin del recorrido", 
			// 	"El recorrido ha finalizado. No hay más obras a la " + sentido, 
			// 	"announcement"
			// ]);

			// return false;
   //  	} // if

	  	// Se carga la interfaz de obra inicial
	  	obra_inicial(id_obra_siguiente);
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

	function medir_obra(tipo)
	{
		var id_obra = $("#id_obra").val();

		switch(tipo) {
			case "confirmacion":
		        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
		        mostrar_mensaje_pie([
		        	"carga", 
		        	"Cargando todos los datos que van a ser almacenados...", 
		        	"Cargando datos para previa revisión"
		    	]);

		        // Carga de interfaz
				cargar_interfaz("cont_principal", "<?php echo site_url('obras/cargar_interfaz'); ?>", {"tipo": "medir_obra_" + tipo, "id": id_obra});
	        break;

			case "descole":
		        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
		        mostrar_mensaje_pie([
		        	"carga", 
		        	"Descole de la obra", 
		        	"Cargando información del descole de la obra."
		    	]);

		        // Carga de interfaz
				cargar_interfaz("cont_principal", "<?php echo site_url('obras/cargar_interfaz'); ?>", {"tipo": "medir_obra_" + tipo, "id": id_obra});
	        break;

	        case "descole_fotos":
	        	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
		        mostrar_mensaje_pie([
		        	"carga", 
		        	"Fotos del descole de la obra", 
		        	"Cargando información de las fotografías del descole de la obra."
		    	]);

		        // Carga de interfaz
				cargar_interfaz("cont_principal", "<?php echo site_url('obras/cargar_interfaz'); ?>", {"tipo": "medir_obra_" + tipo, "id": id_obra});
	        break;

		    case "encole":
		        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
		        mostrar_mensaje_pie([
		        	"carga", 
		        	"Encole de la obra", 
		        	"Cargando información del encole de la obra."
		    	]);

		        // Carga de interfaz
				cargar_interfaz("cont_principal", "<?php echo site_url('obras/cargar_interfaz'); ?>", {"tipo": "medir_obra_" + tipo, "id": id_obra});
	        break;

	        case "encole_fotos":
	        	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
		        mostrar_mensaje_pie([
		        	"carga", 
		        	"Fotos del encole de la obra", 
		        	"Cargando información de las fotografías del encole de la obra."
		    	]);

		        // Carga de interfaz
				cargar_interfaz("cont_principal", "<?php echo site_url('obras/cargar_interfaz'); ?>", {"tipo": "medir_obra_" + tipo, "id": id_obra});
	        break;
		}
	}

	/**
	 * Gestiona el registro del formulario vía ajax
	 */
	function guardar()
	{
		imprimir("fin")
	} // guardar

	/**
	 * Interfaz de obra inicial
	 */
	function obra_inicial(id_obra, mensaje = null, limite = null)
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando la obra inicial...", 
        	"Cargando datos de la obra."
    	]);

    	// Carga de interfaz
		cargar_interfaz("cont_medir", "<?php echo site_url('obras/cargar_interfaz'); ?>", {"tipo": "medir_obra_inicial", "id": id_obra, "limite": limite});
	} // obra_inicial

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
		// Se activan los botones
        botones({"volver": true});

		// Activación de los selects
        $('select[id^="select_"]').dropdown({
			allowAdditions: true
		}); // dropdown

		// Cuando se cambie algún select
        $('select[id^="select_"]').on("change", function () {
        	// Datos para consulta
    		var datos = {
    			"Abscisa_Inicial": $("#select_abscisa_inicial").val(),
    			"Codigo": $("#select_lado option:selected").attr("data-codigo-lado")
    		}
    		// imprimir(datos);
    		
    		// Si todos los campos tienen datos
    		if ($("#select_abscisa_inicial").val() !== "" && $("#select_lado").val() !== "") {
    			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
		        mostrar_mensaje_pie([
		        	"carga", 
		        	"Buscando obra...", 
		        	"Buscando la obra que coincida con los datos elegidos."
		    	]);

    			// Se consulta la obra que corresponda a ese lado y abscisa inicial
	        	obra = ajax("<?php echo site_url('obras/cargar'); ?>", {"tipo": "obra_inicial_medicion", "datos": datos}, "JSON");

	        	// Si se encontró la obra
	    		if (obra.respuesta) {
	    			imprimir("encontrada");

	    			// Se carga la interfaz con la respuesta, sea vacía o el arreglo
    				obra_inicial(obra.respuesta.Pk_Id);
	    		}else{
	    			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
			    	mostrar_mensaje_pie([
			    		"estado", 
			    		"No se encontró la obra", 
			    		"Por favor verifique los datos e intente nuevamente.",
			    		"bug"
					]);
	    		} // if

	    		
    		} // if
		}); // change

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Opciones preliminares cargadas", 
    		"Elija la obra como punto de inicio para comenzar las mediciones.",
    		"announcement"
		]);
	}); // document.ready
</script>