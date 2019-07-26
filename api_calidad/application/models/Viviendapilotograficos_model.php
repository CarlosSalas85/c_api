<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Viviendapilotograficos_model extends CI_Model { 

	public function __construct() {
		parent::__construct();
	}

	public function topRecursos($id = 0){
        $this->db->select('Vp_solicitudRecurso, Vp_solicitudDescripcion, SUM(vp_solicitud_estadoPrecio) as total');
        $this->db->join('vp_solicitud_estado B', 'B.vp_solicitud_idVp_solicitud = A.idVp_solicitud');
		$this->db->group_by('Vp_solicitudRecurso');
		$this->db->order_by('total', 'desc'); 
		if($id != 0){
			$this->db->where('idObra', $id);
        }
		$this->db->where('A.vp_solicitudEstado = 2');
		$this->db->limit(10);		    
        $consulta= $this->db->get('vp_solicitud A');				
		$resultado=$consulta->result_array();
		return $resultado;
	} 	

	public function topActividades($id = 0){
        $this->db->select('Vp_solicitudActividad, SUM(vp_solicitud_estadoPrecio) as total');
        $this->db->join('vp_solicitud_estado B', 'B.vp_solicitud_idVp_solicitud = A.idVp_solicitud');
		$this->db->group_by('Vp_solicitudActividad');
		$this->db->order_by('total', 'desc'); 
		if($id != 0){
			$this->db->where('idObra', $id);
        }
		$this->db->where('A.vp_solicitudEstado = 2');	
		$this->db->limit(10);	    
        $consulta= $this->db->get('vp_solicitud A');				
		$resultado=$consulta->result_array();
		return $resultado;
	} 	

}

