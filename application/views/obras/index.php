<!-- Contenedor -->
<div id="cont_obras"></div><!-- Contenedor -->

<script type="text/javascript">
	/**
	 * Función que carga los lados de una calzada
	 * @return void 
	 */
	function cargar_lados()
	{
		//Se resetea el select
		$("#select_lados").html('');

		// Si se selecciona un valor
	    if($("#select_calzada").val() !== ""){
	    	// Se consultan los lados de la calzada
	    	lados = ajax("<?php echo site_url('configuracion/cargar'); ?> ", {"tipo": "lados", "id": $("#select_calzada").val()}, "JSON");

	   		// Se rellena el select
			rellenar_select("select_lados", lados);
	    } // if
	} // cargar_lados

	/**
	 * Función que carga los puntos de referencia
	 * de una unidad funcional
	 * @return void 
	 */
	function cargar_puntos_referencia()
	{
		//Se resetea el select
		$("#select_punto_referencia").html('');

		// Si se selecciona un valor
	    if($("#select_unidad_funcional").val() !== ""){
	    	// Se consultan los puntos de referencia de la unidad funcional
	    	puntos_referencia = ajax("<?php echo site_url('configuracion/cargar'); ?> ", {"tipo": "puntos_referencia", "id": $("#select_unidad_funcional").val()}, "JSON");

	   		// Se rellena el select
			rellenar_select("select_punto_referencia", puntos_referencia);
	    } // if
	} // cargar_puntos_referencia

	/**
	 * Función que se activa al presionar el botón crear del menú
	 * @return void 
	 */
	function crear()
	{
		// Se carga la interfaz
		cargar_interfaz("cont_obras", "<?php echo site_url('obras/cargar_interfaz'); ?>", {"tipo": "index_crear", "id": 0});
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
		// Se toman los valores
		var descripcion = $("#input_descripcion");
		var abscisa_inicial = $("#input_numero_abscisa_inicial");
		var abscisa_final = $("#input_numero_abscisa_final");
		var descripcion = $("#input_descripcion");
		var id_obra = $("#id_obra").val();
		var unidad_funcional = $("#select_unidad_funcional");
		var punto_referencia = $("#select_punto_referencia");
		var tipo_obra = $("#select_tipo_obra");
		var lado = $("#select_lados");

		// Arreglo con los datos a validar
        datos_obligatorios = new Array(
            punto_referencia.val(),
            abscisa_inicial.val(),
            abscisa_final.val(),
            tipo_obra.val(),
            lado.val()
        );
		// imprimir(datos_obligatorios);

		// Se ejecuta la validación de los datos obligatorios
        validacion = validar_campos_obligatorios(datos_obligatorios);

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
			"carga", 
        	"Verificando información...", 
        	"Validando que se hayan ingresado los datos obligatorios."
    	]);

    	//Si no supera la validacíón
        if (!validacion) {
        	// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Advertencia", 
				"Faltan campos por diligenciar. Por favor asegúrese de ingresar los campos marcados como obligatorios.", 
				"warning sign"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        	mostrar_mensaje_pie([
        		"estado", 
        		"No se puede guardar la obra todavía.", 
        		"Esperando que se diligencien los datos obligatorios.",
        		"announcement"
    		]);

			return false;
        } // if

        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Guardando datos...", 
        	"Ingresando los datos en base de datos."
    	]);

    	// Se recogen los datos a guardar
    	datos = {
    		"Abscisa_Inicial": abscisa_inicial.val(),
    		"Abscisa_Final": abscisa_final.val(),
    		"Descripcion": descripcion.val(),
    		"Fk_Id_Lado": lado.val(),
    		"Fecha_Creacion": "<?php echo date('Y-m-d'); ?>",
    		"Fk_Id_Obra_Tipo": tipo_obra.val(),
    		"Fk_Id_Punto_Referencia": punto_referencia.val(),
    	};
    	imprimir(datos);

    	// Si trae id (registro a actualizar)
    	if (id_obra) {
    		imprimir("Actualizando...")
    		// Se procede a modificar
    		// exito = ajax("<?php echo site_url('obras/actualizar'); ?>", {"tipo": "usuario", "datos": datos, "id": id_usuario}, "HTML");
    	} else {
    		imprimir("Creando...")
    		// Se guarda los datos en la base de datos
    		exito = ajax("<?php echo site_url('obras/insertar'); ?>", {"tipo": "obra", "datos": datos}, "HTML");
    	} // if

    	// Si el registro no es exitoso
    	if (!exito.respuesta) {
    		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Error", 
				"Ha ocurrido un error y la obra no ha podido guardarse. Por favor comuníquese con el administrador del Sistema.", 
				"bug"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	    	mostrar_mensaje_pie([
	    		"estado", 
	    		"No se puede guardar ...", 
	    		"Error desconocido. Comuníquese con el área de Desarrollo",
	    		"bug"
			]);

	    	return false;
    	} //if

    	// Se consulta el tipo de obra
    	
    	// Se guardan las medidas de esa obra
    	





    	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando formato para subida de foto...", 
        	"Generando formato para subir la foto de la obra."
    	]);

    	// Se redirecciona al formulario de subida de foto
    	subir_foto(exito.respuesta);


    	// Se redirecciona a la lista de unidades funcionales
    	// listar("La obra fue creada correctamente");
	} // guardar

	/**
	 * Lista las normas
	 */
	function listar(mensaje = null)
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando obras...", 
        	"Listando todas las obras creadas en el sistema"
    	]);

        // Si trae un mensaje
    	if (mensaje) {
    		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Obra guardada", 
				mensaje, 
				"checkmark circle"
			]);
    	};

    	// Carga de interfaz
		cargar_interfaz("cont_obras", "<?php echo site_url('obras/cargar_interfaz'); ?>", {"tipo": "index_listar"});
	} // listar

	/**
	 * Carga de formulario de subida
	 * de la foto de la obra
	 */
	function subir_foto(id_obra)
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"estado", 
    		"La obra se guardó correctamente.", 
    		"Esperando que se seleccione la foto para la obra.",
    		"checkmark"
    	]);

    	// Carga de interfaz
		cargar_interfaz("cont_obras", "<?php echo site_url('obras/cargar_interfaz'); ?>", {"tipo": "foto_crear", "id": id_obra});
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
		// Por defecto, cargamos la interfaz de la tabla
		listar();
	}); // document.ready
</script>