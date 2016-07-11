<?php
/**
 * Modelo encargado de gestionar toda la informacion de administración
 * y configuración de todo el sistema
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           Concesión Vías del Nus
 */
Class Configuracion_model extends CI_Model{
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
	 * Permite la carga de datos o grupo de datos
	 * @param  string $tipo Tipo
	 * @param  int $id   Id (cuando lo requiere)
	 * @return array       Datos
	 */
	function cargar($tipo, $id)
	{
		// Dependiendo del tipo
    	switch ($tipo) {
			// Unidades funcionales
			case "unidades_funcionales_activas":
				// Consulta
				$this->db_sicc->select('*');
				$this->db_sicc->where("Estado", 1);
				$this->db_sicc->order_by('Codigo');

				// Retorno
		        return $this->db_sicc->get('unidades_funcionales')->result();
			break; // Unidades funcionales

			// Tipos de obras
			case "obras_tipos":
				// Consulta
				$this->db->select('*');
				// $this->db_sicc->where("Estado", 1);
				$this->db->order_by('Nombre');

				// Retorno
		        return $this->db->get('obras_tipos')->result();
			break; // Tipos de obras

			// Unidades de medida de un tipos de obra
			case "obras_tipos_unidades_medida":
				// Consulta
				$this->db->select('*');    
				$this->db->where("Fk_Id_Obra_Tipo", $id);    
				$this->db->from('obras_tipos_mediciones');
				$this->db->join('unidades_medida', 'obras_tipos_mediciones.FK_Id_Unidad_Medida = unidades_medida.Pk_Id');
				
				// Retorno
				return $this->db->get()->result();
			break; // Unidades de medida de un tipos de obra

			// Puntos de referencia
			case "puntos_referencia":
				// Consulta
				$this->db_sicc->select('*');
				$this->db_sicc->where("Fk_Id_Unidad_Funcional", $id);
				$this->db_sicc->order_by('Nombre');

				// Retorno
		        return $this->db_sicc->get('puntos_referencia')->result();
			break; // Puntos de referencia
		} // switch
	} // cargar
}
/* Fin del archivo Configuracion_model.php */
/* Ubicación: ./application/models/Configuracion_model.php */