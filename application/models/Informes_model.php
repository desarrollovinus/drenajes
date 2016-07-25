<?php
/**
 * Modelo encargado de gestionar toda la informacion de
 * los informes del proyecto
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           Concesión Vías del Nus
 */
Class Informes_model extends CI_Model{
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
			// Obras en un rango de abscisas
			case "obras_inventario":
				// Consulta
				$sql =
				"SELECT
					o.Pk_Id
				FROM
					obras AS o
					INNER JOIN sicc.puntos_referencia AS pr ON o.Fk_Id_Punto_Referencia = pr.Pk_Id
				WHERE
					pr.Fk_Id_Unidad_Funcional = {$id['Id_Unidad_Funcional']}
					AND o.Abscisa_Inicial BETWEEN {$id['Abscisado1']}
				AND {$id['Abscisado2']}";
				
				// Resultado
				$obra = $this->db->query($sql)->row();

				// Si encuentra obra
				if (count($obra) > 0) {
					// Retorna el arreglo
					return $obra;
				} // if

				// Retorna vacío
				return null;
			break; // Obras en un rango de abscisas
		} // switch
	} // cargar
}
/* Fin del archivo Informes_model.php */
/* Ubicación: ./application/models/Informes_model.php */