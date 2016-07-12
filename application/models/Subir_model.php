<?php
/**
 * Modelo encargado de gestionar toda la informacion de
 * la subida de archivos al sistema
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           Concesión Vías del Nus
 */
Class Subir_model extends CI_Model{
	/**
    * Función constructora de la clase. Se hereda el mismo constructor de la clase para evitar sobreescribirlo y de esa manera 
    * conservar el funcionamiento de controlador.
    * 
    * @access   public
    */
    function __construct() {
        parent::__construct();
        /*
	     * sicc es la base de datos unificada de configuraciones generales del proyecto. Esta se llama
	     * porque en el archivo database.php la variable ['sicc']['pconnect] esta marcada como false,
	     * lo que quiere decir que no se conecta persistentemente sino cuando se le invoca, como en esta ocasión.
	     */
        $this->db_sicc = $this->load->database('db_sicc', TRUE);
    } // construct

    /**
     * Foto de una obra
     * @param  array $datos Datos de la foto
     * @return true        exito o error
     */
    function foto_obra($id, $datos){
        // Si se actualiza
        $this->db->where('Pk_Id', $id);
        if($this->db->update('obras', $datos)){
            //Retorna verdadero
            return true;
        } // if
    } // foto_obra
}
/* Fin del archivo Subir_model.php */
/* Ubicación: ./application/models/Subir_model.php */