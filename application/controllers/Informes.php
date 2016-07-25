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
Class Informes extends CI_Controller {
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

        // Carga de modelos, librerías, helpers y demás
        $this->load->model(array('Configuracion_model', 'Obras_model', 'Informes_model'));
        
        // Se carga la librería PDF
        require('system/libraries/Fpdf.php');

        //Definir la ruta de las fuentes
        define('FPDF_FONTPATH','system/fonts/');

        // Carga de permisos
        // $this->data['permisos'] = $this->session->userdata('Permisos');
    } // construct

    /**
     * Informes gráficos
     */
    function graficos(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Suiche por tipo
            switch ($this->input->post("tipo")) {
                // 
                case "":
                    // Se carga la vista
                    // $this->load->view("informes/graficos/calibraciones_por_entidad");
                break; // 
            } // suiche
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // graficos

    /**
     * Informes en PDF
     */
    function pdf(){
        // Suiche tipo
        switch ($this->uri->segment(3)) {
            // 
            case "obras":
                // Se carga la vista
                $this->load->view("informes/pdf/obras");
            break; // 
        } // switch
    } // pdf

}
/* Fin del archivo Informes.php */
/* Ubicación: ./application/controllers/Informes.php */