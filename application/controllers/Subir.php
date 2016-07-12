<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Drenajes - Subida de archivos
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           Concesión Vías del Nus
 *
 */
Class Subir extends CI_Controller {
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
        $this->load->model(array('Subir_model', 'Obras_model'));

        // Carga de permisos
        // $this->data['permisos'] = $this->session->userdata('Permisos');
    } // construct

    //Se declara la variable que contiene la ruta predeterminada para la subida de los archivos
    var $ruta = './archivos/';

    /**
     * Foto de una obra
     */
    function foto_obra(){
        // Se toman los datos por POST
        $id_obra = $this->uri->segment(3);

        // Se establece el directorio
        $directorio = "{$this->ruta}obras/{$id_obra}/";

        // Se consulta los datos de la obra
        $obra = $this->Obras_model->cargar("obra", $id_obra);

        // Se almacena el nombre de la foto actual
        $foto_actual = $obra->Foto;

        //Valida que el directorio exista. Si no existe,lo crea con el id obtenido
        if( ! is_dir($directorio)){
            //Asigna los permisos correspondientes
            @mkdir($directorio, 0777);
        }//Fin if

        // Variables de éxito 
        $exito_archivo = false;
        $exito_registro = false;

        //Declaramos una variable mensaje quue almacenara el resultado de las operaciones.
        $mensaje = "";

        // Recorrido de los archivos
        foreach ($_FILES as $key){
            // Si el archivo se pasa correctamente
            if($key['error'] == UPLOAD_ERR_OK ){
                //Obtenemos el nombre original del archivo
                $nombre = $key['name'];

                // Si el fichero existe
                if (file_exists($directorio.$nombre)) {
                    echo "existe";
                } else  if (move_uploaded_file($key['tmp_name'], $directorio.$nombre)) {
                    //La subida es ok
                    $exito_archivo = true;

                    //Se almacena un arreglo con la información
                    $datos = array(
                        "Foto" => $nombre
                    ); // datos

                    //Si se guarda la calibración en base de datos correctamente
                    if( $this->Subir_model->foto_obra($id_obra, $datos) ){
                        // Se borra el archivo anterior
                        unlink($directorio.$foto_actual);

                        // Se retorna la ruta completa
                        echo $directorio.$nombre;

                        //Se inserta el registro de logs enviando tipo de log y dato adicional si corresponde
                        // $this->logs_model->insertar(55, "Equipo ".$id_obra);
                    } // if
                } // if
            } // if

        //     // Si se guardaron los dos
        //     if ($exito_archivo && $exito_registro) {
        //         // Retorna verdadero
        //         echo true;
        //     } else {
        //         // Retorna falso
        //         // echo $key['error'];
        //         echo false;
        //     } // if
        } // foreach $_files
    } // foto_obra


}
/* Fin del archivo Subir.php */
/* Ubicación: ./application/controllers/Subir.php */