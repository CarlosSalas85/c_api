<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Viviendapilotocantidad_model extends CI_Model { 

	public function __construct() {
		parent::__construct();
	}

	public function cantidadSolicitudes($id = 0){
		$this->db->select('vp_solicitudEstado, COUNT(vp_solicitudEstado) as total');
		$this->db->group_by('vp_solicitudEstado');
		if($id != 0){
			$this->db->where('idObra', $id);
		}		    
		$consulta= $this->db->get('vp_solicitud');
		$resultado=$consulta->result_array();
		return $resultado;
	} 	

}

