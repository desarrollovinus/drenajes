<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Drenajes - Configuración
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           Concesión Vías del Nus
 *
 */
Class Configuracion extends CI_Controller {
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
        $this->load->model(array('Configuracion_model'));

        // Carga de permisos
        // $this->data['permisos'] = $this->session->userdata('Permisos');
    } // construct

	/**
     * Carga de datos
     * @return void 
     */
    function cargar()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
        	// Se reciben los datos por POST
            $tipo = $this->input->post('tipo');

            // Dependiendo del tipo
            switch ($tipo) {
                // Puntos de referencia
                case 'puntos_referencia':
                	//Se ejecuta el modelo que carga los datos
                    print json_encode($this->Configuracion_model->cargar($tipo, $this->input->post('id')));
                break; // Puntos de referencia
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // cargar
}
/* Fin del archivo Configuracion.php */
/* Ubicación: ./application/controllers/Configuracion.php */