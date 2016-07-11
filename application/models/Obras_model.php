<?php
/**
 * Modelo encargado de gestionar toda la informacion de
 * las obras del proyecto
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           Concesión Vías del Nus
 */
Class Obras_model extends CI_Model{
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
			// Obras
			case "obras":
				// Consulta
				$sql =
				"SELECT
					o.Pk_Id,
					o.Abscisa_Inicial,
					o.Abscisa_Final,
					uf.Codigo AS Unidad_Funcional_Codigo,
					ot.Nombre AS Tipo,
					pr.Nombre AS Punto_Referencia
				FROM
					drenajes.obras AS o
				LEFT JOIN sicc.puntos_referencia AS pr ON o.Fk_Id_Punto_Referencia = pr.Pk_Id
				LEFT JOIN sicc.unidades_funcionales AS uf ON pr.Fk_Id_Unidad_Funcional = uf.Pk_Id
				LEFT JOIN drenajes.obras_tipos AS ot ON o.Fk_Id_Obra_Tipo = ot.Pk_Id
				ORDER BY
					Unidad_Funcional_Codigo ASC,
					o.Abscisa_Inicial ASC,
					o.Abscisa_Final ASC";

				// Retorno
		        return $this->db->query($sql)->result();
			break; // Obras
		} // switch
	} // cargar

    /**
     * Permite la inserción de datos en la base de datos 
     * @param  string $tipo  Tipo de inserción
     * @param  array $datos Datos que se van a insertar
     * @return boolean        true: exito
     */
    function insertar($tipo, $datos)
    {
        switch ($tipo) {
            // Obra
            case "obra":
                // Si se guarda correctamente
                if($this->db->insert('obras', $datos)){
                    // Se retorna el id
                    return $this->db->insert_id();
                } // if
            break; // Obra
        } // suiche
    } // insertar
}
/* Fin del archivo Obras_model.php */
/* Ubicación: ./application/models/Obras_model.php */