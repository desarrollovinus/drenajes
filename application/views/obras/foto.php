<h2 class="ui dividing header center aligned azul">
	Foto de la obra
</h2>

<?php
// Se consultan los datos de la foto
$datos_foto = $this->Configuracion_model->cargar("datos_foto", $id);

// Se almacenan las variables
$url_foto = $datos_foto[0]; 
$descripcion_foto = $datos_foto[1];
?>

<div class="ui segment">
	<!-- Foto de la obra -->
	<img class="ui centered medium image" src="<?php echo $url_foto; ?>">
	
	<!-- Descripción -->
	<br><p class="text-center"><?php echo $descripcion_foto; ?></p>
</div>

<!-- Estilo del input -->
<label for="archivos" class="ui icon button">
	<i class="file icon"></i> Subir foto
</label>

<!-- Input -->
<input type="file" id="archivos" style="display:none">

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se activan los botones
        botones({"listar": true});

        // Cuando se elija un archivo para subir
        $("input[type='file']").on("change", function(){
        	// Id de la obra
        	id_obra = "<?php echo $id; ?>";

        	// Se sube el anexo
            archivo = ajax_archivos("fotos", "<?php echo site_url('subir/foto_obra" + "/" + id_obra + "'); ?>");

            // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	        mostrar_mensaje_pie([
	        	"carga", 
	        	"Subiendo foto...", 
	        	"Subiendo foto y asociándola a la obra creada. Por favor espere..."
	    	]);

            // Si existe el archivo
            if (archivo == "existe") {
                // Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
				modal([
					"Error", 
					"El archivo que intenta subir ya existe. Por favor elija otro o cambie el nombre.", 
					"bug"
				]);

				return false;
            } // if

            // Si se subió la foto
            if (archivo) {
            	// Se redirecciona al formulario de subida de foto
    			subir_foto(id_obra, "La foto se subió correctamente.");
            } // if
        }); // input change
   	}); // document.ready
</script> 