<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Solicitudesreportes_model extends CI_Model { 

   public function __construct() {
      parent::__construct();
   }  

   public function getAll(){
    $this->base();
    $consulta=$this->db->get();
    $resultado=$consulta->result_array();
    return $resultado;
   } 

   public function getAllEstado($id){
    $this->base();    
    $this->db->where('A.Solicitud_estado', $id);
    $consulta=$this->db->get();
    $resultado=$consulta->result_array();
    return $resultado;
   } 

   public function getAllObra($id){
    $this->base();    
    $this->db->where('B.ObraCtoCentroCosto', $id);
    $consulta=$this->db->get();
    $resultado=$consulta->result_array();
    return $resultado;
  } 

   private function base(){
    $this->db->select('*');
    $this->db->from('solicitud A');
    $this->db->join('obra B', 'B.idObra = A.Obra_idObra');
    $this->db->join('estado C', 'C.idEstado = A.Solicitud_estado');
    $this->db->join('causales D', 'D.idCausales = A.Causales_idCausales');
    $this->db->join('solicitud_estados E', 'E.Solicitud_idSolicitud = A.idSolicitud AND E.Estado_idEstado = A.Solicitud_estado');
    $this->db->join('solicitud_valores F', 'F.Solicitud_estados_idSolicitud_estados = E.idSolicitud_estados');
    $this->db->join('usuario G', 'G.idUsuario = E.Usuario_idUsuario');
   }

}

