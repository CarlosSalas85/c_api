<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Causales_model extends CI_Model { 

   public function __construct() {
      parent::__construct();
   }

   public function get($id = null){
      if(!is_null($id)){
        $query = $this->db->select('*')->from('causales')->where('idCausales', $id)->get();

        if($query->num_rows() === 1){
          return $query->row_array();
        }        
      }

      $query = $this->db->select('*')->from('causales')->get();

      if($query->num_rows() > 0){
        return $query->result_array();
      }else{
        
      }

   }
   
   public function validate($data){
     $query = $this->db->select('*')->from('causales')->where('CausalesNombre', $data['CausalesNombre'])->get();

        if($query->num_rows() === 1){
          return true;
        }else{
          return false;
        }  
   }

   public function save($data){   

    $this->db->insert('causales', $this->_setObra($data));
    if($this->db->affected_rows() === 1){
      return $this->db->insert_id();
    }
    return false;
   }

   public function update($id, $data){ 

     $this->db->where('idCausales', $id);
     $this->db->update('causales', $this->_setObra($data));

    if($this->db->affected_rows() === 1){
      return true;
    }
    return false;
   }

   public function delete($id){
    $this->db->where('idCausales', $id)->delete('causales');
    if($this->db->affected_rows() === 1){
      return true;
    }
    return false;
   }

   private function _setObra($data){
     return array('CausalesNombre' => $data['CausalesNombre'],
      'CausalesRequisito' => $data['CausalesRequisito'],
      'CausalesTipo' => $data['CausalesTipo'],);
   }

  
}