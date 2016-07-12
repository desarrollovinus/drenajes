<h2 class="ui dividing header center aligned azul">
	Foto de la obra
</h2>

<?php
// Se consulta los datos de la obra
$obra = $this->Obras_model->cargar("obra", $id);

// Ruta de la foto
$url_foto = "./archivos/obras/{$id}/{$obra->Foto}";

// Si hay foto
if (isset($url_foto) && file_exists($url_foto)) {
	// Se carga la descripción por defecto
	$descripcion_foto = "Para cambiar la foto, haga clic en la foto actual, o haga clic en el ícono superior.";
} else {
	// Se carga el logo de Vinus
	$url_foto = "http://www.vinus.com.co/predios/img/logo_vinus.png";

	// Se carga la descripción por defecto
	$descripcion_foto = "No hay foto asociada a esta obra. Haga clic en el logo para subir una, o haga clic en el ícono superior para volver al listado de obras.";
} // if
?>

<div class="ui segment">
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
    			subir_foto(id_obra);
            } // if
        }); // input change
   	}); // document.ready
</script> 