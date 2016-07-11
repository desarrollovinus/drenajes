<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Drenajes - Obras
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           Concesión Vías del Nus
 *
 */
Class Obras extends CI_Controller {
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
        $this->load->model(array('Configuracion_model', 'Obras_model'));

        // Carga de permisos
        // $this->data['permisos'] = $this->session->userdata('Permisos');
    } // construct

	/**
     * Carga la interfaz según el tipo
     * @return void 
     */
    function cargar_interfaz()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Dependiendo del tipo
            switch ($this->input->post('tipo')) {
                // Index
                case 'index':
                    // Se carga la vista
                    $this->load->view('obras/index');
                break; // Index

                // Crear obras
                case 'index_crear':
                	// Se recibe por post la variable que define si es un registro nuevo o existente
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('obras/crear', $this->data);
                break; // Crear obras

                // Listar obras
                case 'index_listar':
                    // Se carga la vista
                    $this->load->view('obras/listar');
                break; // Listar obras

                // Unidades de medida aplicables al tipo de obra seleccionado
                case 'unidades_medida_obra_tipo':
                	// Se recibe por post el id del tipo de obra
                    $this->data["id_tipo_obra"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('obras/unidades_medida', $this->data);
                break; // Unidades de medida aplicables al tipo de obra seleccionado
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // cargar_interfaz

    /**
     * Proceso de registro de base de datos
     * @return boolean 
     */
    function insertar()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se recibe el array de datos por post
            $datos = $this->input->post('datos');
            $tipo = $this->input->post('tipo');

            // Dependiendo del tipo
            switch ($tipo) {
                // Obra
                case 'obra':
                    // Inserción
                    $guardar = $this->Obras_model->insertar($tipo, $datos);

                    // Si se guarda correctamente
                    if ($guardar > 0) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        // $this->configuracion_model->insertar_log(6, "{$datos['Nombres']} {$datos['Apellidos']} ($guardar)");

                        // Se retorna verdadero
                        echo $guardar;
                    } // if
                break; // Obra
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // insertar
}
/* Fin del archivo Obras.php */
/* Ubicación: ./application/controllers/Obras.php */