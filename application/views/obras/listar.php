<h2 class="ui dividing header center aligned azul">
	Obras del proyecto
</h2>

<div class="table_responsive">
	<table class="table table-striped table-hover" id="tbl_obras">
		<thead>
			<tr>
				<th class="text-center">Nro.</th>
				<th class="text-center">Unidad funcional</th>
				<th class="text-center">Punto de referencia</th>
				<th class="text-center">Abscisa inicial (ms)</th>
				<th class="text-center">Abscisa final (ms)</th>
				<th class="text-center">Lado</th>
				<th class="text-center">Tipo</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Contador
			$cont = 1;

			// Recorrido de los registros
			foreach ($this->Obras_model->cargar("obras", NULL) as $obra) {
			?>
				<tr>
					<td class="text-right"><?php echo $cont++; ?></td>
					<td><?php echo $obra->Unidad_Funcional_Codigo; ?></td>
					<td><?php echo $obra->Punto_Referencia; ?></td>
					<td><?php echo $obra->Abscisa_Inicial; ?></td>
					<td><?php echo $obra->Abscisa_Final; ?></td>
					<td><?php echo $obra->Lado; ?></td>
					<td><?php echo $obra->Tipo; ?></td>
					
				</tr>
			<?php } // foreach ?>
		</tbody>
	</table>
</div>		
				
<script>
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de los checkboxes
        // $('.ui.checkbox').checkbox();
        
        // Activación de la tabla
        $('#tbl_obras').DataTable({
	    	paging: true,
	    	"scrollX": true
		});

		// Se activan los botones
        botones({"crear": true, "volver": true, "editar": true, "eliminar": true});
        
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"estado", 
        	"Obras", 
        	"Todas las obras creadas en el proyecto",
        	"road"
    	]);
	}); // document.ready
</script>