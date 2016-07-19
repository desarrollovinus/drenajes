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
     * Actualización de registros en base de datos
     */
    function actualizar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se reciben los datos por POST
            $datos = $this->input->post('datos');
            $id = $this->input->post('id');
            $tipo = $this->input->post('tipo');

            // Dependiendo del tipo
            switch ($tipo) {
                // Medición
                case 'medicion':
                    // Se ejecuta el modelo
                    echo $this->Obras_model->actualizar($tipo, $id, $datos);

                    // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                    // $this->configuracion_model->insertar_log(24, "{$datos['Nombre']} ({$id})");
                break; // Medición
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // actualizar

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
                // Obra en la que se iniciará la medición
                case 'obra_inicial_medicion':
                    //Se ejecuta el modelo que carga los datos
                    print json_encode($this->Obras_model->cargar($tipo, $this->input->post('datos')));
                break; // Obra en la que se iniciará la medición

                // Todos los id de las obras
                case 'obras_id':
                    //Se ejecuta el modelo que carga los datos
                    print json_encode($this->Obras_model->cargar($tipo, NULL));
                break; // Todos los id de las obras
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // cargar

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
                // Subida de foto de la obra
                case 'foto_crear':
                    // Se recibe por post la variable que define si es un registro nuevo o existente
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('obras/foto', $this->data);
                break; // Subida de foto de la obra

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

                // Medición de obras
                case 'medir':
                    // Se carga la vista
                    $this->load->view('obras/medir/index');
                break; // Medición de obras
                
                // Confirmación de datos
                case 'medir_obra_confirmacion':
                    // Se recibe por post la variable que define si es un registro nuevo o existente
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('obras/medir/obra_confirmacion', $this->data);
                break; // Confirmación de datos

                // Descole de la obra
                case 'medir_obra_descole':
                    // Se recibe por post la variable que define si es un registro nuevo o existente
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('obras/medir/obra_descole', $this->data);
                break; // Descole de la obra

                // Fotos del descole de la obra
                case 'medir_obra_descole_fotos':
                    // Se recibe por post la variable que define si es un registro nuevo o existente
                    $this->data["id"] = $this->input->post("id");
                    $this->data["tipo_medicion"] = $this->input->post("tipo_medicion");
                    $this->data["numero"] = $this->input->post("numero");

                    // Se carga la vista
                    $this->load->view('obras/medir/obra_fotos', $this->data);
                break; // Fotos del descole de la obra

                // Encole de la obra
                case 'medir_obra_encole':
                    // Se recibe por post la variable que define si es un registro nuevo o existente
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('obras/medir/obra_encole', $this->data);
                break; // Encole de la obra

                // Fotos del encole generales de la obra
                case 'medir_obra_encole_fotos':
                    // Se recibe por post la variable que define si es un registro nuevo o existente
                    $this->data["id"] = $this->input->post("id");
                    $this->data["tipo_medicion"] = $this->input->post("tipo_medicion");
                    $this->data["numero"] = $this->input->post("numero");

                    // Se carga la vista
                    $this->load->view('obras/medir/obra_fotos', $this->data);
                break; // Fotos del encole de la obra

                // Datos generales de la obra
                case 'medir_obra_inicial':
                    // Se recibe por post la variable que define si es un registro nuevo o existente
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('obras/medir/obra_inicial', $this->data);
                break; // Datos de la obra

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
     * Borrado de registros en base de datos
     */
    function eliminar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Datos por POST
            $tipo = $this->input->post("tipo");

            // Suiche
            switch ($tipo) {
                // Valores de medida de una obra
                case "valores":
                    // Se ejecuta el modelo
                    echo $this->Obras_model->eliminar($tipo, $this->input->post("id_obra"));
                break; // Valores de medida de una obra
            } // switch
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    } // eliminar

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
                // Medición
                case 'medicion':
                    // Inserción
                    $guardar = $this->Obras_model->insertar($tipo, $datos);

                    // Si se guarda correctamente
                    if ($guardar > 0) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        // $this->configuracion_model->insertar_log(6, "{$datos['Nombres']} {$datos['Apellidos']} ($guardar)");

                        // Se retorna verdadero
                        echo $guardar;
                    } // if
                break; // Medición

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

                // Valores de medida de una obra
                case 'valores':
                    // Inserción
                    $guardar = $this->Obras_model->insertar($tipo, $datos);

                    // Si se guarda correctamente
                    if ($guardar > 0) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        // $this->configuracion_model->insertar_log(6, "{$datos['Nombres']} {$datos['Apellidos']} ($guardar)");

                        // Se retorna verdadero
                        echo $guardar;
                    } // if
                break; // Valores de medida de una obra
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // insertar
}
/* Fin del archivo Obras.php */
/* Ubicación: ./application/controllers/Obras.php */