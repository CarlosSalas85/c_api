<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Solicitudes_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function save_solicitud($data_uno)
  {
    $this->db->insert(
      'solicitud',
      array(
        'Solicitud_cantidad' => $data_uno['Solicitud_cantidad'],
        'Solicitud_Total' => $data_uno['Solicitud_Total'],
        'SolicitudCantidad_enOrden' => $data_uno['SolicitudCantidad_enOrden'],
        'SolicitudCantidad_porComprar' => $data_uno['SolicitudCantidad_porComprar'],
        'SolicitudCantidad_recepcion' => $data_uno['SolicitudCantidad_recepcion'],
        'SolicitudUltimo_precio' => $data_uno['SolicitudUltimo_precio'],
        'SolicitudArchivo' => $data_uno['SolicitudArchivo'],
        'SolicitudJustificacion' => $data_uno['SolicitudJustificacion'],
        'SolicitudRecurso_codigo' => $data_uno['SolicitudRecurso_codigo'],
        'SolicitudRecurso_nombre' => $data_uno['SolicitudRecurso_nombre'],
        'SolicitudRecurso_unidad' => $data_uno['SolicitudRecurso_unidad'],
        'Causales_idCausales' => $data_uno['Causales_idCausales'],
        'idObra' => $data_uno['Obra_idObra'],
        'SolicitudEstado' => $data_uno['Solicitud_estado'],
      )
    );
    return $this->db->insert_id();
  }

  public function actualizarSolicitud($id_solicitud, $data_uno)
	{
		$this->db->where('idSolicitud', $id_solicitud);
		$this->db->update('solicitud', array(
      'SolicitudObservacion' => $data_uno['SolicitudObservacion'],
      'SolicitudEstado' => $data_uno['SolicitudEstado'],
      'SolicitudNumero_orden' => $data_uno['SolicitudNumero_orden']
    ));

		if ($this->db->affected_rows() === 1) {
			return true;
		}
		return false;
	}

  public function save_solicitudEstados($data_dos, $id_solicitud)
  {
    $this->db->insert(
      'solicitud_estados',
      array(
        'Solicitud_estadosFecha' => $data_dos['Solicitud_estadosFecha'],
        'idUsuario' => $data_dos['idUsuario'],
        'Solicitud_estadosEstado' => $data_dos['Solicitud_estadosEstado'],
        'Solicitud_estadosNueva_cantidad' => $data_dos['Solicitud_estadosNueva_cantidad'],
        'Solicitud_estadosNuevo_total' => $data_dos['Solicitud_estadosNuevo_total'],
        'Solicitud_idSolicitud' => $id_solicitud,       
      )
    );
    return $this->db->insert_id();
  }

  public function save_solicitudRecurso($data_tres, $id_solicitud)
  {
    $this->db->insert(
      'solicitud_recurso',
      array(
        'Solicitud_recursoCodigo' => $data_tres['Solicitud_recursoCodigo'],
        'Solicitud_recursoDescripcion' => $data_tres['Solicitud_recursoDescripcion'],
        'Solicitud_recursoUnidad' => $data_tres['Solicitud_recursoUnidad'],
        'Solicitud_recursoCantidad' => $data_tres['Solicitud_recursoCantidad'],
        'Solicitud_recursoPrecio' => $data_tres['Solicitud_recursoPrecio'],
        'Solicitud_idSolicitud' => $id_solicitud,
      )
    );
    return $this->db->insert_id();
  }

  public function getDetalle($id)
  {
    $this->base();
    $this->db->where('A.idSolicitud', $id);
    $consulta = $this->db->get();
    $resultado = $consulta->row_array();
    return $resultado;
  }

  public function getRecurso($id)
  {
    $this->db->select('*');
    $this->db->from('solicitud_recurso A');
    $this->db->where('A.Solicitud_idSolicitud', $id);
    $consulta = $this->db->get();
    $resultado = $consulta->row_array();
    return $resultado;
  }

  public function getHistorial($id)
  {
    $this->db->select('*');
    $this->db->from('solicitud_estados A');
    $this->db->where('A.Solicitud_idSolicitud', $id);
    $consulta = $this->db->get();
    $resultado = $consulta->result_array();
    return $resultado;
  }

  private function base()
  {
    $this->db->select('*');
    $this->db->from('solicitud A');
    $this->db->join('obra B', 'B.idObra = A.Obra_idObra');
    $this->db->join('estado C', 'C.idEstado = A.Solicitud_estado');
    $this->db->join('causales D', 'D.idCausales = A.Causales_idCausales');
    $this->db->join('solicitud_estados E', 'E.Solicitud_idSolicitud = A.idSolicitud AND E.Estado_idEstado = A.Solicitud_estado');
    $this->db->join('solicitud_valores F', 'F.Solicitud_estados_idSolicitud_estados = E.idSolicitud_estados');
    $this->db->join('usuario G', 'G.idUsuario = E.Usuario_idUsuario');
  }

  public function eliminarSolicitud($id)
	{
		$this->db->where('idSolicitud', $id)->delete('solicitud');
		if ($this->db->affected_rows() === 1) {
			return true;
		}
		return false;
	}
}
