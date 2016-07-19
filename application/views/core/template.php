<!DOCTYPE html>
<html lang="es">
	<head>
		<?php $this->load->view('core/header'); ?>
	</head>
	<body>
		<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Input donde almacenaremos el nombre de la clase que tiene el ícono
		del pié de página, para después poder removerlo y que se deje poner el otro -->
        <input type="hidden" id="icono_pie" value="vacío">

        <!-- Inputs ocultos que almacenan la url site y base para usarla en funciones javascript -->
        <input id="url_configuracion_cargar" type="hidden" value="<?php echo site_url('configuracion/cargar') ?>">

        <!-- Input oculto con el id de la medición de ua obra. Se ubica aquí para que pueda ser leído por todas las interfaces -->
		<input type="hidden" id="id_medicion" >

		<!-- Modal Mensaje -->
		<div id="modal_mensaje" class="ui basic small test modal">
			<i class="close icon"></i>

			<!-- Título -->
			<div class="header"></div>

			<!-- Contenido -->
			<div class="content">
				<div class="image">
					<i class="icon"></i>
				</div>
				<div class="description">
					<p></p>
				</div>
			</div>
			<div class="actions">
				<div class="two fluid ui inverted buttons">
					<!-- Botón 1 -->
					<!-- <div class="ui red basic inverted button">
						<i class="remove icon"></i>
						Cerrar
					</div> -->

					<!-- Botón 2 -->
					<!-- <div class="ui green basic inverted button">
						<i class="checkmark icon"></i>
						De acuerdo
					</div> -->
				</div>
			</div>
		</div>
		<!-- Modal Mensaje -->

		<!-- Modal Eliminación -->
		<div id="modal_eliminacion" class="ui basic small test modal">
			<i class="close icon"></i>

			<!-- Título -->
			<div class="header"></div>

			<!-- Contenido -->
			<div class="content">
				<div class="image">
					<i class="icon"></i>
				</div>
				<div class="description">
					<p></p>
				</div>
			</div>
			<div class="actions">
				<div class="two fluid ui inverted buttons">
					<!-- Botón 1 -->
					<div class="ui red basic inverted button">
						<i class="remove icon"></i>
						No, cancelar
					</div>

					<!-- Botón 2 -->
					<div onClick="javascript:eliminar('aceptacion')" class="ui green basic inverted button">
						<i class="checkmark icon"></i>
						Si, eliminar
					</div>
				</div>
			</div>
		</div>
		<!-- Modal Eliminación -->

		<nav>
			<?php
			// Si ya ha iniciado sesión
			// if($this->session->userdata('Pk_Id_Usuario')){
				// Carga de menú
				$this->load->view("core/menu");
			// } // if
			?>
		</nav>
		
		<!-- Container -->
		<div class="container">
			<div id="cont_principal">
				<!-- Carga de contenido principal -->
				<?php $this->load->view($contenido_principal); ?>	
			</div>
			<!-- Contenedor para que los datos no queden bajo el footer fijo -->
			<div class="limite_pie"></div>
		</div>
		<!-- /container -->

		<!-- Librerías -->
        <script src="<?php echo base_url(); ?>js/plugins/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>semantic/dist/semantic.min.js"></script>
        <script src="<?php echo base_url(); ?>js/funciones.js"></script>

        <footer>
			<!-- Carga de pié de página -->
			<?php $this->load->view("core/footer"); ?>
		</footer>
	</body>
</html>