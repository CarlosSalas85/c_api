<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Solicitudestados_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function getAll($estado)
  {
    $this->base();
    $this->db->where('A.SolicitudEstado', $estado);
    $this->db->limit(1000);
    $consulta = $this->db->get();
    $resultado = $consulta->result_array();
    return $resultado;
  }

  public function getAllAo($estado, $idUsuario)
  {
    $this->base();
    $this->db->where('A.SolicitudEstado = "' . $estado . '" AND  C.idUsuario = "' . $idUsuario . '"');
    $consulta = $this->db->get();
    $resultado = $consulta->result_array();
    return $resultado;
  }

  public function getAllPgr($estado)
  {
    $this->base();
    $this->db->where('A.SolicitudEstado = "' . $estado . '" AND (Causales_idCausales = 5 OR Causales_idCausales = 3 OR Causales_idCausales = 4)');
    $consulta = $this->db->get();
    $resultado = $consulta->result_array();
    return $resultado;
  }

  public function getAllPrevencion($estado)
  {
    $this->base();
    $this->db->where('A.SolicitudEstado = "' . $estado . '" AND Causales_idCausales = 1');
    $consulta = $this->db->get();
    $resultado = $consulta->result_array();
    return $resultado;
  }

  public function getAllPresupuesto($estado)
  {
    $this->base();
    $this->db->where('A.SolicitudEstado = "' . $estado . '" AND (Causales_idCausales = 2  OR Causales_idCausales = 6)');
    $consulta = $this->db->get();
    $resultado = $consulta->result_array();
    return $resultado;
  }

  public function getCentroCostoAo($estado, $obra, $idUsuario)
  {
    $this->base();
    $this->db->where('A.SolicitudEstado = "' . $estado . '" AND A.idObra = "' . $obra . '" AND  C.idUsuario = "' . $idUsuario . '"');
    $consulta = $this->db->get();
    $resultado = $consulta->result_array();
    return $resultado;
  }

  public function getCentroCosto($estado, $obra)
  {
    $this->base();
    $this->db->where('A.SolicitudEstado = "' . $estado . '" AND A.idObra = "' . $obra . '"');
    $consulta = $this->db->get();
    $resultado = $consulta->result_array();
    return $resultado;
  }

  public function getCentroCostoPgr($estado, $obra)
  {
    $this->base();
    $this->db->where('A.SolicitudEstado = "' . $estado . '" AND A.idObra = "' . $obra . '" AND(Causales_idCausales = 5 OR Causales_idCausales = 3 OR Causales_idCausales = 4)');
    $consulta = $this->db->get();
    $resultado = $consulta->result_array();
    return $resultado;
  }

  public function getCentroCostoPrevencion($estado, $obra)
  {
    $this->base();
    $this->db->where('A.SolicitudEstado = "' . $estado . '" AND A.idObra = "' . $obra . '" AND Causales_idCausales = 1');
    $consulta = $this->db->get();
    $resultado = $consulta->result_array();
    return $resultado;
  }

  public function getCentroCostoPresupuesto($estado, $obra)
  {
    $this->base();
    $this->db->where('A.SolicitudEstado = "' . $estado . '" AND A.idObra = "' . $obra . '" AND (Causales_idCausales = 2  OR Causales_idCausales = 6)');
    $consulta = $this->db->get();
    $resultado = $consulta->result_array();
    return $resultado;
  }

  private function base()
  {
    $this->db->select('
    idSolicitud,
    Solicitud_cantidad,
    Solicitud_Total,
    SolicitudCantidad_enOrden,
    SolicitudCantidad_porComprar,
    SolicitudCantidad_recepcion,
    SolicitudUltimo_precio,
    SolicitudNumero_orden,
    SolicitudArchivo,
    SolicitudJustificacion,
    SolicitudObservacion,
    SolicitudRecurso_codigo,
    SolicitudRecurso_nombre,
    SolicitudRecurso_unidad,
    idObra,
    SolicitudEstado,

    CausalesNombre,

    Solicitud_estadosFecha,
    idUsuario,
    Solicitud_estadosNueva_cantidad,
    Solicitud_estadosNuevo_total
    ');
    $this->db->from('solicitud A');
    $this->db->join('causales B', 'B.idCausales = A.Causales_idCausales');
    $this->db->join('solicitud_estados C', 'C.Solicitud_estadosEstado = A.SolicitudEstado AND C.Solicitud_idSolicitud = A.idSolicitud');
  }   

}
