<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Inicio
 */
Class Inicio extends CI_Controller {
	/**
    * Función constructora de la clase. Esta función se encarga de verificar que se haya
    * iniciado sesión. si no se ha iniciado, inmediatamente redirecciona
    * 
    * Se hereda el mismo constructor de la clase para evitar sobreescribirlo y de esa manera 
    * conservar el funcionamiento de controlador.
    * 
    * @access   public
    */
	function __construct() {
        parent::__construct();

        //Si no ha iniciado sesión
        if(!$this->session->userdata('Pk_Id_Usuario')){
            //Se cierra la sesión obligatoriamente
            // redirect('sesion/cerrar');
        }//Fin if

        //Carga de modelos, librerías, helpers y demás
        // $this->load->model(array('sesion_model', 'configuracion_model'));

        // Carga de permisos
        // $this->data['permisos'] = $this->session->userdata('Permisos');
    } // construct

	/**
	 * Interfaz inicial
	 * @return void 
	 */
	function index()
	{
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Inicio';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'inicio/index';
        //Se carga la plantilla con las demas variables
        $this->load->view('core/template', $this->data);
	} // index



}
/* Fin del archivo Inicio.php */
/* Ubicación: ./application/controllers/Inicio.php */