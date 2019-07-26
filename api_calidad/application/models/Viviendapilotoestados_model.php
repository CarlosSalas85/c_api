<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Viviendapilotoestados_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get($id)
	{
		$query = $this->db->select('*')->from('vp_solicitud_estado')->where('vp_solicitud_idvp_solicitud', $id)->get();       
        return $query->result_array();
            
	}
}
