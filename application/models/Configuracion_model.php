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
			// Calzadas
			case "calzadas":
				// Consulta
				$this->db->select('*');
				$this->db->order_by('Nombre');

				// Retorno
		        return $this->db->get('calzadas')->result();
			break; // Calzadas

			// Datos de la foto de una obra
			case 'datos_foto':
				$this->load->model("Obras_model");

				// Se consulta los datos de la obra
				$obra = $this->Obras_model->cargar("obras", $id);

				// Ruta de la foto
				$url_foto = "./archivos/obras/{$id}/{$obra->Foto}";

				// Si hay foto
				if (isset($url_foto) && file_exists($url_foto)) {
					// Se carga la descripción por defecto
					$descripcion_foto = "Para cambiar la foto, haga clic en la foto actual, o haga clic en el ícono superior.";
				} else {
					// Se carga el logo de Vinus
					$url_foto = "http://www.vinus.com.co/predios/img/logo_vinus.png";

					// Se carga la descripción por defecto
					$descripcion_foto = "No hay foto asociada a esta obra. Haga clic en el logo para subir una, o haga clic en el ícono superior para volver al listado de obras.";
				} // if

				return array($url_foto, $descripcion_foto); 
			break; // Datos de la foto de una obra

			// Lados
			case "lados":
				// Consulta
				$this->db->select('*');
				$this->db->order_by('Nombre');
				
				// Si trae calzada
				if ($id) {
					// Filtra las de esa calzada
					$this->db->where('Fk_Id_Calzada', $id);
				} else {
					// Agrupa para mostrar solo los nombres diferentes
					$this->db->group_by('Nombre');
				} // if

				// Retorno
		        return $this->db->get('lados')->result();
			break; // Lados

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

			// Unidades funcionales
			case "unidades_funcionales_activas":
				// Consulta
				$this->db_sicc->select('*');
				$this->db_sicc->where("Estado", 1);
				$this->db_sicc->order_by('Codigo');

				// Retorno
		        return $this->db_sicc->get('unidades_funcionales')->result();
			break; // Unidades funcionales
		} // switch
	} // cargar
}
/* Fin del archivo Configuracion_model.php */
/* Ubicación: ./application/models/Configuracion_model.php */