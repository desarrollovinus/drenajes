/**
 * Permite procesar una solicitud vía Ajax
 * @param  {string} url            Url del controlador a donde irá
 * @param  {JSON} datos          arreglo de datos enviados
 * @param  {string} tipo_respuesta Es lo que espera como respuesta, sea texto o JSON
 * @return {string o JSON}                Dato que retornará
 */
function ajax(url, datos, tipo_respuesta)
{
	//Variable de exito
    var exito;

    // Petición ajax
	$.ajax({
		url: url,
		type: "POST",
		dataType: tipo_respuesta, // xml, json, script o html
		data: datos,
		async: false,
		success: function(respuesta){
			// Arreglo con los datos a retornar
			exito = {
				"estado": true,
				"respuesta": respuesta
			} // if
		}, // success
		error: function(respuesta){
			// Arreglo con los datos a retornar
			exito = {
				"estado": false,
				"respuesta": respuesta,
				"mensaje": respuesta
			} // if
		} // error
	});

	// Se retorna el arreglo
	return exito;
} // ajax

/**
 * Permite procesar una solicitud vía Ajax
 * @param  {string} tipo Tipo de archivo, para validaciones
 * @param  {string} url            Url del controlador a donde irá
 * @return {string o JSON}                Dato que retornará
 */
function ajax_archivos(tipo, url){
	// Declaración de variables
    var archivos = document.getElementById("archivos");
    var mensaje;

    // Se recorren los archivos para validaciones
    for (var i = 0; i < archivos.files.length; ++i) {
		// Variables
        var nombre = archivos.files.item(i).name;
		var nombre_validar = nombre.split(".")[0];
        var extension = (nombre.substring(nombre.lastIndexOf("."))).toLowerCase();

        // si tiene caracteres especiales
        if (validar_caracteres(nombre)) {
        	// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Error", 
				"El archivo " + nombre + " no puede tener tildes ni caracteres especiales como la letra ñ. Cambie el nombre e intente subirlo nuevamente.", 
				"bug"
			]);
            
            // Se detiene
            return false;
        } // if

        // Si el tipo de archivo es foto
        if(tipo == "fotos"){
            // Se valida que sea imagen
            if (!(extension && /^(.jpg|.JPG|.png|.PNG|.gif|.GIF)$/.test(extension))){
                // Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
				modal([
					"Error", 
					"Una o varias fotos que intenta subir no están en formato JPG, GIF o PNG. Verifique por favor e intente subirlas nuevamente.", 
					"bug"
				]);

                return false;
            } // if
        } // if
    } // for

    // Obtenemos los archivos seleccionados en el input
	var archivo = archivos.files;

    // Creamos una instancia del Objeto FormData.
    var archivos = new FormData();

    // Recorrido de los archivos
    for(i = 0; i < archivo.length; i++){
        // Añadimos cada archivo a el arreglo con un indice direfente
        archivos.append('archivo' + i, archivo[i]);
    } // for

    /*Ejecutamos la función ajax de jQuery*/        
    $.ajax({
        url: url,
        async: false,
        type:'POST', //Metodo que usaremos
        contentType:false, //Debe estar en false para que pase el objeto sin procesar
        data: archivos, //Le pasamos el objeto que creamos con los archivos
        processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false, //Para que el formulario no guarde cache
        success: function(respuesta){
            mensaje = respuesta;
        },
        error: function(respuesta){
            mensaje = respuesta;
        }
    });
    
    // Se retorna el mensaje
    return mensaje;
} // ajax_archivos

/**
 * Configuración de los botones que aparecen activos en
 * el menú superior derecho
 * @param  array parametros Arreglo JSON con los botones activos o inactivos
 * @return {[type]}            [description]
 */
function botones(parametros)
{
	imprimir(parametros)
	// Se declaran las variables
	var crear = $("#icono_crear");
	var editar = $("#icono_editar");
	var eliminar = $("#icono_eliminar");
	var guardar = $("#icono_guardar");
	var historial = $("#icono_historial");
	var listar = $("#icono_listar");
	var pdf = $("#icono_pdf");
	var volver = $("#icono_volver");
	var medir = $("#icono_medir");
	var anterior = $("#icono_anterior");
	var siguiente = $("#icono_siguiente");
	var continuar_medicion = $("#icono_continuar");

	// Se ocultan todos los íconos por defecto
	crear.hide();
	editar.hide();
	eliminar.hide();
	guardar.hide();
	historial.hide();
	listar.hide();
	pdf.hide();
	volver.hide();
	medir.hide();
	anterior.hide();
	siguiente.hide();
	continuar_medicion.hide();

	// Si trae alguna Configuración
	if (parametros) {
		// Activamos según los parámetros verdaderos
		if (parametros.crear) { 
			crear.show(); 
			crear.popup({inline: true});
		};

		if (parametros.editar) { 
			editar.show(); 
			editar.popup({inline: true});
		};

		if (parametros.eliminar) { 
			eliminar.show(); 
			eliminar.popup({inline: true});
		};

		if (parametros.guardar) { 
			guardar.show(); 
			guardar.popup({inline: true});
		};

		if (parametros.historial) { 
			historial.show(); 
			historial.popup({inline: true});
		};

		if (parametros.listar) { 
			listar.show(); 
			listar.popup({inline: true});
		};

		if (parametros.pdf) { 
			pdf.show(); 
			pdf.popup({inline: true});
		};

		if (parametros.volver) { 
			volver.show(); 
			volver.popup({inline: true});
		};

		if (parametros.medir) { 
			medir.show(); 
			medir.popup({inline: true});
		};

		if (parametros.anterior) { 
			anterior.show(); 
			anterior.popup({inline: true});
		};

		if (parametros.siguiente) { 
			siguiente.show(); 
			siguiente.popup({inline: true});
		};

		if (parametros.continuar_medicion) { 
			continuar_medicion.show(); 
			continuar_medicion.popup({inline: true});
		};
	} // if
} // botones

/**
 * Carga la interfaz seleccionada
 * @param  {string} contenedor Nombre del contenedor donde se va a cargar
 * @param  {string} url        Url que va a cargar
 * @param  {array} datos      Datos a cargar
 * @return {void}            
 */
function cargar_interfaz(contenedor, url, datos)
{
	// Configuración de los botones (de esta manera entran desactivados)
	botones();

	// Se limpia la consola
	console.clear();

	// Carga de la interfaz
	$("#" + contenedor).hide().load(url, datos).fadeIn('500');
	// $("#" + contenedor).load(url, datos).animate({ marginLeft: "100%"} , 4000);
} // cargar_interfaz

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
    	lados = ajax($("#url_configuracion_cargar").val(), {"tipo": "lados", "id": $("#select_calzada").val()}, "JSON");

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
    	puntos_referencia = ajax($("#url_configuracion_cargar").val(), {"tipo": "puntos_referencia", "id": $("#select_unidad_funcional").val()}, "JSON");

   		// Se rellena el select
		rellenar_select("select_punto_referencia", puntos_referencia);
    } // if
} // cargar_puntos_referencia

/**
 * Esta función cuenta los checks para saber cuáles imprimirá
 * en reportes o en otra cosa
 * @return {boolean} true: tiene al menos uno; false: no tiene ninguno seleccionado
 */
function marcar_checks(){
	// Variable contadora
	var cont = 0;

	var ids = new Array();

	// Se recorren los checkbox chequeados
	$("input[name='seleccionado']:checked").each(function(index){
		// Aumento del contador
		cont++;
		ids.push($("input[name='seleccionado']:checked").attr("id"));
	});

	// // Si hay solo un check seleccionado
	// if (cont > 0) {
	// 	// Exito
	// 	return $("input[name='seleccionado']:checked").attr("id");
	// }else{
	// 	// Retorno falso
	// 	return false;
	// } // if

	imprimir(ids)
} // marcar_checks

/**
 * Imprime un mensaje en consola
 * @param  {string} mensaje Mensaje a imprimir
 * @return {string}         Mensaje a imprimir
 */
function imprimir(mensaje)
{
	// Se imprime el mensaje
	console.log(mensaje);
} // imprimir

/**
 * Mensaje mostrado al pié de la página
 * @param  {array} datos Datos de carga
 * @return {void}       
 */
function mostrar_mensaje_pie(datos)
{
	// Nombre de la clase del ícono del pié de página
	var icono_pie = $("#icono_pie").val();

	// Suiche
	switch(datos[0]) {
		// Usado cuando se esté cargando una interfaz
		case "carga":
			$("#cargador .header").text(datos[1]); // Agrega el título
			$("#cargador>i").removeClass(icono_pie); // Elimina los íconos anteriores
			$("#cargador>i").addClass("circle loading"); // Agrega los íconos y la animación
			$("#cargador p").text(datos[2]); // Agrega la descripción
		break;

		// Usado cuando se esté cargando una interfaz
		case "estado":
			$("#cargador .header").text(datos[1]); // Agrega el título
			$("#cargador>i").removeClass("circle loading " + icono_pie); // Elimina la animación y los íconos anteriores
			$("#cargador p").text(datos[2]); // Agrega la descripción
			$("#icono_pie").val(datos[3]); // Almacena el nuevo ícono vigente
			$("#cargador>i").addClass(datos[3]); // Agrega el nuevo ícono
		break;

		// Cuando ya realizó la acción
		case "final":
			setTimeout(function(){
				$("#cargador .header").text(datos[1]); // Agrega el título
				$("#cargador>i").removeClass("circle loading " + icono_pie); // Elimina la animación y los íconos anteriores
				$("#cargador p").text(datos[2]); // Agrega la descripción
				$("#cargador>i").addClass(datos[3]); // Agrega el nuevo ícono
			}, 3500);
		break;
	} // Suiche
} // mensaje_pie

function mensaje_pie()
{
	imprimir("cambiar nombre de función")
}

/**
 * Activa o desactiva el menú lateral
 * @return void
 */
function menu_lateral(){
    // Activa o desactiva el botón
    $('.ui.sidebar').sidebar('toggle');
} // menu_lateral

/**
 * Muestra un mensaje como modal. Se usa para todo tipo
 * de mensajes de aviso y confirmación
 * @param  {string} titulo  Título del mensaje
 * @param  {string} mensaje Descripción del mensaje a enviar
 * @param  {string} icono   Nombre de la clase del ícono que va a mostar
 */
function modal(datos)
{
	// Se ponen los valores que se reciben antes de enviar el modal
	$('#modal_mensaje .image>i').addClass(datos[2]);
	$('#modal_mensaje .header').text(datos[0])
	$('#modal_mensaje .description>p').text(datos[1]);

	// Se abre el modal
	$('#modal_mensaje').modal('show');
} // modal

/**
 * Muestra un mensaje como modal. Se usa para 
 * los mensajes de confirmación de eliminación de registros
 * @param  {string} titulo  Título del mensaje
 * @param  {string} mensaje Descripción del mensaje a enviar
 * @param  {string} icono   Nombre de la clase del ícono que va a mostar
 */
function modal_eliminacion(datos)
{
	// Se ponen los valores que se reciben antes de enviar el modal
	$('#modal_eliminacion .image>i').addClass(datos[2]);
	$('#modal_eliminacion .header').text(datos[0])
	$('#modal_eliminacion .description>p').text(datos[1]);

	// Se abre el modal
	$('#modal_eliminacion').modal('show');
} // modal_eliminar

/**
 * Redirecciona al sitio indicado
 * @param  {string} url Url a donde redireccionará
 * @return {void}     
 */
function redireccionar(url)
{
    //Se redirecciona
    location.href = url;
} // redireccionar

/**
 * Ingresa los datos a las listas desplegables
 * @param  {string} 		elemento Nombre del select
 * @param  {int} array      	Arreglo con datos
 */
function rellenar_select(elemento, array)
{
	//Se recorren los registros
    $.each(array.respuesta, function(key, val){
        //Se agrega cada sede al select
        $("#" + elemento).append("<option value='" + val.Pk_Id + "'>" + val.Nombre + "</option>");
    })//Fin each
} // rellenar_select

/**
 * Permite que todos los checks de una tabla o una lista
 * se seleccionen o deseleccionen
 */
function seleccionar_todo(tabla)
{
	// Si el elemento está siendo chequeado
	if ($("#todos").is(":checked")) {
        // Estará activo
        activo = true;
	} else {
        // Estará desactivado
        activo = false;
	} // if

	// Definición de tanla
	oTable = $('#' + tabla).dataTable();

	// Si está chequeado
	if ($("#todos").is(":checked")){
        // Se chequean todos
        $('input[name=\'seleccionado\']', oTable.fnGetNodes()).prop('checked', activo);
    } else {
    	// Se desactivan todos los checks
        $('input[name=\'seleccionado\']', oTable.fnGetNodes()).removeAttr('checked');
    } // if
} // seleccionar_todo

/**
 * Pone un valor por defecto a un select
 * @param  {string} elemento Nombre del select
 * @param  {string} valor    Valor del option
 */
function select_por_defecto(elemento, valor)
{
	// Se pone el valor por defecto al elemento seleccionado
	$('#' + elemento + ' option[value="' + valor + '"]').attr("selected",true);
} // select_por_defecto

/**
 * Escanea todos los campos en búsqueda de campos vacíos
 * @param  {array} campos Textos de los campos a validar
 * @return {boolean}        1: Campos con información; 0: campos pendientes por llenar
 */
function validar_campos_obligatorios(campos)
{
    //Variable contadora
    validacion = 0;

    //Recorrido para validar cada campo
    for (var i = 0; i < campos.length; i++){
        // validacion campo a campo
        if($.trim(campos[i]) != "") {
        	// Se aumenta el contador
            validacion++;
        } // if
    } // for

    //Si todos los campos superan la validación
    if (validacion == campos.length) {
        //Retorna ok
        return true;
    } else {
        //Retorna falso
        return false;
    } // if

    //Se resetea la variable contadora
    validacion = 0;
} // validar_campos_obligatorios

/**
 * Esta función valida los caracteres seleccionados
 * @return {boolean} true: tiene solo uno; false: tiene varios seleccionados
 */
function validar_caracteres(valor)
{
    // Si tiene uno de esos valores
    if (valor.match('[á,é,í,ó,ú]|[Á,É,Í,Ó,Ú]|[ñ,Ñ]')) {
        // Se retorna falso
        return true;
    } // if
} // validar_caracteres

/**
 * Esta función valida los checks para que tenga solo uno
 * seleccionado, para posteriormente editarlo
 * @return {boolean} true: tiene solo uno; false: tiene varios seleccionados
 */
function validar_checks(){
	// Variable contadora
	var cont = 0;

	// Se recorren los checkbox chequeados
	$("input[name='seleccionado']:checked").each(function(index){
		// Aumento del contador
		cont++;

		// imprimir("El checkbox con valor " + $(this).attr("id") + " está seleccionado");
	});

	// Si hay solo un check seleccionado
	if (cont == 1) {
		// Exito
		return $("input[name='seleccionado']:checked").attr("id");
	}else{
		// Retorno falso
		return false;
	} // if
} // validar_checks