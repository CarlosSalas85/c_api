<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Graficos_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function valoresCausalesAll()
  {
    $this->_baseValoresCausales();
    $consulta = $this->db->get('solicitud', 10);
    $resultado = $consulta->result_array();
    return $resultado;
  }

  public function valoresCausalesObra($obra)
  {
    $this->_baseValoresCausales();
    $this->db->where('idObra', $obra);
    $consulta = $this->db->get('solicitud', 10);
    $resultado = $consulta->result_array();
    return $resultado;
  }

  private function _baseValoresCausales()
  {
    $this->db->select('CausalesNombre, COUNT(Causales_idCausales) as total');
    $this->db->group_by('Causales_idCausales');
    $this->db->order_by('total', 'desc');
    $this->db->join('causales', 'idCausales = Causales_idCausales');
  }

  public function valoresTopRecursosAll()
  {
    $this->db->select('SolicitudRecurso_nombre, SUM(Solicitud_estadosNuevo_total) as total');
    $this->db->from('solicitud');
    $this->db->group_by('SolicitudRecurso_nombre');
    $this->db->order_by('total', 'desc');
    $this->_setValoresDesviacion();
    $this->db->where('SolicitudEstado = 4');
    $this->db->limit(10);
    $consulta = $this->db->get();
    $resultado = $consulta->result_array();
    return $resultado;
  }

  public function valoresTopRecursosObra($obra)
  {
    $this->db->select('SolicitudRecurso_nombre, SUM(Solicitud_estadosNuevo_total) as total');
    $this->db->from('solicitud');
    $this->db->group_by('SolicitudRecurso_nombre');
    $this->db->order_by('total', 'desc');
    $this->_setValoresDesviacion();
    $this->db->where('SolicitudEstado = 4');
    $this->db->where('idObra', $obra);
    $this->db->limit(10);
    $consulta = $this->db->get();
    $resultado = $consulta->result_array();
    return $resultado;
  }
    
  private function _setValoresDesviacion()
  {
    $this->db->join('solicitud_estados', 'Solicitud_idSolicitud = idSolicitud AND Solicitud_estadosEstado = SolicitudEstado');
  }

  public function solicitudes()
  {
    $this->db->select('idSolicitud, Causales_idCausales');
    $this->db->from('solicitud');
    $this->db->order_by('Causales_idCausales', 'asc');           
    $consulta = $this->db->get();
    $resultado = $consulta->result_array();
    return $resultado;
  } 

  public function fechaSolicitud($id, $estado)
  {
    $this->db->select('Solicitud_estadosFecha');
    $this->db->from('solicitud_estados');
    $this->db->where('Solicitud_idSolicitud', $id);
    $this->db->where('Solicitud_estadosEstado', $estado);
    $consulta = $this->db->get();
    $resultado = $consulta->result_array();
    return $resultado;
  }

  public function TotalUsuariosPerfil()
  {
    $this->db->select('idPerfil, PerfilNombre, COUNT(Perfil_idPerfil) as total');
    $this->db->group_by('Perfil_idPerfil');
    $this->db->order_by('total', 'desc');
    $this->db->join('perfil', 'idPerfil = Perfil_idPerfil');
    $consulta = $this->db->get('usuario');
    $resultado = $consulta->result_array();
    return $resultado;
  }

  public function UsuariosPerfil()
  {
    $this->db->select('UsuarioNombre, UsuarioCorreo, Perfil_idPerfil');
    $this->db->order_by('Perfil_idPerfil', 'asc');
    $this->db->join('perfil', 'idPerfil = Perfil_idPerfil');
    $consulta = $this->db->get('usuario');
    $resultado = $consulta->result_array();
    return $resultado;
  }

  public function TotalSolicitudes()
  {
    $this->_baseTotalSolicitudes();
    $consulta = $this->db->get('solicitud', 10);
    $resultado = $consulta->result_array();
    return $resultado;
  }

  public function TotalSolicitudesObra($obra)
  {
    $this->_baseTotalSolicitudes();
    $this->db->where('idObra', $obra);
    $consulta = $this->db->get('solicitud', 10);
    $resultado = $consulta->result_array();
    return $resultado;
  }

  private function _baseTotalSolicitudes()
  {
    $this->db->select('SolicitudEstado, COUNT(SolicitudEstado) as total');
    $this->db->group_by('SolicitudEstado');
  }
}
