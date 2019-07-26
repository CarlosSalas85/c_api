<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Viviendapiloto_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$CI = &get_instance();
		$this->DB2 = $CI->load->database('tablas_maestras', TRUE);
	}

	public function save_vpSolicitud($data)
	{
		$this->db->insert(
			'vp_solicitud',
			array(
				'idObra' => $data['Obra_idObra'],
				'vp_solicitudEstado' => $data['estado'],
				'Vp_solicitudDescripcion' => $data['DescripcionRecurso'],
				'Vp_solicitudUnidad' => $data['CodigoUnidad'],
				'Vp_solicitudCantidad' => $data['CantidadRecursoActividad'],
				'Vp_solicitudPrecio' => $data['PrecioRecurso'],
				'Vp_solicitudActividad' => $data['CodigoActividad'],
				'Vp_solicitudRecurso' => $data['CodigoRecurso'],
			)
		);
		return $this->db->insert_id();
	}

	public function save_vpEstado($data_dos, $id_solicitud)
	{
		$this->db->insert(
			'vp_solicitud_estado',
			array(
				'vp_solicitud_idVp_solicitud' => $id_solicitud,
				'idUsuario' => $data_dos['usuario'],
				'vp_solicitud_estadoEstado' => $data_dos['estado'],
				'vp_solicitud_estadoFecha' => $data_dos['fecha'],
				'vp_solicitud_estadoCantidad' => $data_dos['nuevaCantidad'],
				'vp_solicitud_estadoPrecio' => $data_dos['nuevoPrecio'],
			)
		);
		return $this->db->insert_id();
	}

	public function obtenerSolicitudes($idObra = 0, $idEstado, $idUsuario = 0)
	{

		$this->db->select('idVp_solicitud,			
			Vp_solicitudActividad,
			Vp_solicitudRecurso, 
			Vp_solicitudDescripcion, 
			Vp_solicitudUnidad, 
			Vp_solicitudCantidad, 
			Vp_solicitudPrecio,
			vp_solicitud_estadoCantidad, 
			vp_solicitud_estadoPrecio, 
			vp_solicitud_estadoFecha,
			idObra,
			vp_solicitudEstado,
			idUsuario,			
			');
		$this->db->from('vp_solicitud A');
		$this->db->join('vp_solicitud_estado B', 'B.vp_solicitud_idvp_solicitud = A.idVp_solicitud AND B.vp_solicitud_estadoEstado = A.vp_solicitudEstado');
		if ($idObra != 0) {
			$this->db->where('A.idObra = "' . $idObra . '" AND A.vp_solicitudEstado = "' . $idEstado . '"');
		} else {
			$this->db->where('A.vp_solicitudEstado = "' . $idEstado . '"');
		}

		if ($idUsuario != 0) {
			$this->db->where('B.idUsuario = "' . $idUsuario . '"');
		}
		$this->db->order_by('A.idVp_solicitud', 'desc');
		$this->db->limit(1000);
		$consulta = $this->db->get();
		$resultado = $consulta->result_array();
		return $resultado;
	}

	public function proyecto($id)
	{
		$query = $this->DB2->select('proyectoNombre')->from('proyecto')->where('idproyecto', $id)->get()->row();
		return $query->proyectoNombre;
	}

	public function usuario($id)
	{
		$query = $this->DB2->select('usuarioNombre, usuarioEmail')->from('usuario')->where('idusuario', $id)->get();
		return $query->row();
	}


	public function eliminarSolicitud($id)
	{
		$this->db->where('idVp_solicitud', $id)->delete('vp_solicitud');
		if ($this->db->affected_rows() === 1) {
			return true;
		}
		return false;
	}

	public function actualizarVpSolicitud($id_solicitud, $data_dos)
	{
		$this->db->where('idVp_solicitud', $id_solicitud);
		$this->db->update('vp_solicitud', array('vp_solicitudEstado' => $data_dos['estado']));

		if ($this->db->affected_rows() === 1) {
			return true;
		}
		return false;
	}
}
