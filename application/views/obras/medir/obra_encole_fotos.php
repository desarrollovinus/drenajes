<!-- Recorrido de las fotos -->
<?php
for ($i=1; $i <= 2; $i++) {
	// Se consultan los datos de la foto
	$datos_foto = $this->Configuracion_model->cargar("datos_foto_medicion", array("Fk_Id_Medicion" => $id, "Numero" => $i, "Fk_Id_Foto_Tipo" => 1));

	// Se almacenan las variables
	$url_foto = $datos_foto[0];
	$descripcion_foto = $datos_foto[1];
?>

<div class="ui segment">
	<!-- Estilo del input -->
	<label for="archivos" class="ui icon button">
		<i class="file icon"></i> Subir foto
	</label>

	
	<!-- Título -->
	<h2 class="ui right floated header azul">
		
<?php echo "$i"; ?>
		<!-- Input -->
		<input type="file" name="archivo<?php echo "$i"; ?>" data-numero="<?php echo $i; ?>" id="archivos" style="display:none">
		Encole - Foto <?php echo $i; ?></h2>

	<div class="ui clearing divider"></div>
	
	<p>
		<!-- Foto de la obra -->
		<img class="ui centered medium image" width="420px" src="<?php echo $url_foto; ?>">
	</p>

	<p>
		<!-- Descripción -->
		<p class="text-center"><?php echo $descripcion_foto; ?></p>
	</p>

	<p>
		
	</p>
</div>

	<?php	
	} // for

	?>
	
	





<script type="text/javascript">
	/**
	 * Interfaz anterior
	 */
	function anterior_medicion()
	{
    	// Se llama la función que contiene los formularios de medición
		medir_obra("encole", $("#id_medicion").val());
	} // anterior_medicion

	/**
	 * Almacenamiento de datos de la interfaz
	 * y continuación la la siguiente
	 */
	function continuar_medicion()
	{
    	// Se llama la función que contiene los formularios de medición
		medir_obra("descole", $("#id_medicion").val());
	} // continuar_medicion
	
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se activan los botones
        botones({"volver": true, "continuar_medicion": true, "anterior_medicion": true});

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Fotografías del encole", 
    		"Tome o suba las fotos correspondientes al encole de la obra que está midiendo.",
    		"announcement"
		]);

		// Cuando se elija un archivo para subir
        // $("input[type='file']").on("change", function(){
        $("input[name='archivo1'], input[name='archivo2']").on("change", function(){
        	// Id de la medición
        	id_medicion = "<?php echo $id; ?>";

        	// Se sube la foto
            // archivo = ajax_archivos("fotos", "<?php echo site_url('subir/foto_medicion" + "/" + id_medicion + "/" + $(this).attr("name") + "'); ?>");
            if ($("input[name='archivo1']").val() != "") {
            	imprimir("es el 1")
            }else{
            	imprimir("es el 2")

            }

    //         // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	   //      mostrar_mensaje_pie([
	   //      	"carga", 
	   //      	"Subiendo foto...", 
	   //      	"Subiendo foto y asociándola a la obra creada. Por favor espere..."
	   //  	]);

    //         // Si existe el archivo
    //         if (archivo == "existe") {
    //             // Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
				// modal([
				// 	"Error", 
				// 	"El archivo que intenta subir ya existe. Por favor elija otro o cambie el nombre.", 
				// 	"bug"
				// ]);

				// return false;
    //         } // if

    //         // Si se subió la foto
    //         if (archivo) {
    //         	// Se redirecciona al formulario de subida de foto
    // 			subir_foto(id_obra, "La foto se subió correctamente.");
    //         } // if
        }); // input change
	}); // document.ready
</script>