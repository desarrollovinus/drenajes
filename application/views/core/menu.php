<div id="menu_superior" class="ui menu">
	<!-- Ícono menú -->
    <a onclick="javascript:menu_lateral()" class="item">
        <i class="large sidebar icon" ></i>
    </a>
	
	<!-- Ícono atrás -->
    <a id="icono_volver" onclick="javascript:volver()" class="item" data-content="Volver" data-variation="inverted">
        <i class="large reply icon"></i>
    </a>

	<!-- Menú superior derecho -->
    <div class="right menu">
		<!-- Historial -->
        <a id="icono_historial" class="item" onClick="javascript:historial();" data-content="Ver historial en la aplicación" data-variation="inverted">
            <i class="unhide icon"></i>
        </a>

        <!-- Guardar -->
        <a id="icono_guardar" class="item" onClick="javascript:guardar();" data-content="Guardar" data-variation="inverted">
            <i class="save icon"></i>
        </a>

        <!-- Listar -->
        <a id="icono_listar" class="item" onClick="javascript:listar();" data-content="Mostrar todos los registros" data-variation="inverted">
            <i class="table icon"></i>
        </a>

        <!-- Agregar -->
        <a id="icono_crear" class="item" onClick="javascript:crear();" data-content="Crear nuevo registro" data-variation="inverted">
            <i class="plus icon"></i>
        </a>

        <!-- Editar -->
        <a id="icono_editar" class="item" onClick="javascript:editar();" data-content="Editar registro" data-variation="inverted">
            <i class="edit icon"></i>
        </a>

        <!-- Eliminar -->
        <a id="icono_eliminar" class="item" onClick="javascript:eliminar('confirmacion');" data-content="Eliminar registro" data-variation="inverted">
            <i class="trash icon"></i>
        </a>

        <!-- Generar PDF -->
        <a id="icono_pdf" class="item" onClick="javascript:generar_reporte('pdf');" data-content="Generar PDF" data-variation="inverted">
            <i class="file pdf outline icon"></i>
        </a>

        <!-- Anterior -->
        <a id="icono_anterior" class="item" onClick="javascript:siguiente('izquierda');" data-content="Obra anterior" data-variation="inverted">
            <i class="chevron left icon"></i>
        </a>

        <!-- Siguiente -->
        <a id="icono_siguiente" class="item" onClick="javascript:siguiente('derecha');" data-content="Siguiente obra" data-variation="inverted">
            <i class="chevron right icon"></i>
        </a>

        <!-- Medir -->
        <a id="icono_medir" class="item" onClick="javascript:medir_obra('encole');" data-content="Iniciar medición" data-variation="inverted">
            <i class="dashboard icon"></i>
        </a>

        <!-- Continuar medición -->
        <a id="icono_continuar" class="item" onClick="javascript:continuar_medicion();" data-content="Continuar medición" data-variation="inverted">
            <i class="toggle right icon"></i>
        </a>

	</div><!-- Menú superior derecho -->
</div>

<div id="menu_lateral" class="ui left vertical inverted labeled icon sidebar menu active">
	<!-- Para el menú de cada aplicación -->
    <?php // if ($menu != "general") { ?>
        <!-- Inicio -->
        <a class="item" onClick="javascript:cargar_principal('inicio')">
            <i class="home icon"></i>
            Inicio
        </a>
    <?php // } // if ?>

    <!-- Medir -->
    <a class="item" onClick="javascript:cargar_principal('medir')">
        <i class="add circle icon"></i>
        Medir
    </a>

    <!-- Mediciones anteriores -->
    <a class="item" onClick="javascript:cargar_principal('mediciones_anteriores')">
        <i class="browser icon"></i>
        Mediciones<br> anteriores
    </a>

    <!-- Obras -->
    <a class="item" onClick="javascript:cargar_principal('obras')">
        <i class="road icon"></i>
        Obras
    </a>


	







</div>

<script type="text/javascript">
	/**
     * Carga por Ajax la interfaz seleccionada
     */
    function cargar_principal(tipo){
        // Dependiendo del tipo
        switch(tipo) {
            // Medir
            case "medir":
                // Se carga la interfaz
                cargar_interfaz("cont_principal","<?php echo site_url('obras/cargar_interfaz'); ?>", {"tipo": "medir"});
            break; // Medir

           	// Obras
            case "obras":
                // Se carga la interfaz
                cargar_interfaz("cont_principal","<?php echo site_url('obras/cargar_interfaz'); ?>", {"tipo": "index"});
            break; // Obras
        } // switch tipo

        // Se quita el menú
        menu_lateral();
    } // switch
</script>