<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Recursossolicitud_model extends CI_Model { 

   public function __construct() {
      parent::__construct();
   }

   public function getAo($usuario){
    $this->base();
    $this->db->where('C.idUsuario', $usuario);
    $this->db->limit(1000);
    $consulta=$this->db->get();
    $resultado=$consulta->result_array();
    return $resultado;
   }

   public function getAll(){
    $this->base();    
    $this->db->limit(1000);
    $consulta=$this->db->get();
    $resultado=$consulta->result_array();
    return $resultado;
   }

   public function detalle($id){
    $this->base();
    $this->db->where('A.idRecurso_Solicitud', $id);    
    $consulta=$this->db->get();
    $resultado=$consulta->result_array();
    return $resultado;
   }

   public function update($id, $data){
     $this->db->where('idRecurso_Solicitud', $id);
     $this->db->update('recurso_solicitud', array(
      'Recurso_idEstado' => $data['Estado_idEstado'],
    ));

     if($this->db->affected_rows() === 1){
      return true;
    }
    return false;
   }

   public function insert($data_dos){
     $this->db->insert('recurso_solicitud', 
      array('Recurso_SolicitudNombre' => $data_dos['Recurso_SolicitudNombre'],
        'Recurso_SolicitudMotivo' => $data_dos['Recurso_SolicitudMotivo'],
        'Recurso_idEstado' => $data_dos['Recurso_idEstado'],                   
      ));
     return $this->db->insert_id();
   }
   
   public function insertEstado($id, $data){
     $this->db->insert('recursosolicitudestados', 
      array('Recurso_Solicitud_idRecurso_Solicitud' => $id,
        'Usuario_idUsuario' => $data['Usuario_idUsuario'],
        'Estado_idEstado' => $data['Estado_idEstado'],
        'RecursoSolicitudEstadoFecha' => $data['RecursoSolicitudEstadoFecha'],                   
      ));
     return $this->db->insert_id();
   }

   public function deleteEstado($id){
    $this->db->where('Recurso_Solicitud_idRecurso_Solicitud', $id)->delete('recursosolicitudestados');
    if($this->db->affected_rows() === 1){
      return true;
    }
    return false;
   }

   public function delete($id){
    $this->db->where('idRecurso_Solicitud', $id)->delete('recurso_solicitud');
    if($this->db->affected_rows() === 1){
      return true;
    }
    return false;
   }

   private function base(){
     $this->db->select('*');
     $this->db->from('recurso_solicitud A');
     $this->db->join('recursosolicitudestados B', 'B.Recurso_Solicitud_idRecurso_Solicitud = A.idRecurso_Solicitud AND Recurso_idEstado = B.Estado_idEstado');
     $this->db->join('usuario C', 'C.idUsuario = B.Usuario_idUsuario');
     $this->db->join('estado D', 'D.idEstado = B.Estado_idEstado');     
   }  
}