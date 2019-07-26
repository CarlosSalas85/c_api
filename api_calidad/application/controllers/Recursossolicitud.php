<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Recursossolicitud extends REST_Controller {	

	public function __construct() {
		parent::__construct();
	    $this->load->model('Recursossolicitud_model');
	}

	public function find_get($id){

		if(!$id){
			$this->response(null,400);
		}

		$datos = explode("-", $id);

		$perfil = $datos[0];
		$usuario = $datos[1];		

		if($perfil != 3){

			$data = $this->Recursossolicitud_model->getAll();

		}else{
			
			$data = $this->Recursossolicitud_model->getAo($usuario);
		}	

		$this->response($data);
	}

	public function index_put($id){

		$data = array('Usuario_idUsuario' => $this->put('usuario'),
			'RecursoSolicitudEstadoFecha' => $this->put('fecha'),
			'Estado_idEstado' => $this->put('estado'),			
		);		

		$update = $this->Recursossolicitud_model->update($id, $data);

		if($update == true){

			$update = $this->Recursossolicitud_model->insertEstado($id, $data);

			if(empty($update)){
				$dato = 0;
			}else{
				$dato = 1;
			}

		}else{}
		
		$this->response($dato);
	}

	public function index_post(){

		if(!$this->post('nombre')){
			$this->response(null,400);
		}

		$data_dos = array('Recurso_SolicitudNombre' => mb_strtoupper($this->post('nombre')),
			'Recurso_SolicitudMotivo' => ucfirst($this->post('motivo')),
			'Recurso_idEstado' => $this->post('estado'),);

		$data = array('Usuario_idUsuario' => $this->post('usuario'),
			'RecursoSolicitudEstadoFecha' => $this->post('fecha'),
			'Estado_idEstado' => $this->post('estado'),			
		);		

		$id = $this->Recursossolicitud_model->insert($data_dos);		

		if(!is_null($id)){

			 $data = $this->Recursossolicitud_model->insertEstado($id, $data);

		}else{

			$data = 0;
		}

		$this->response($data);		
	}


	public function index_delete($id){

		if(!is_null($id)){			
		}
		
		if($this->Recursossolicitud_model->deleteEstado($id) == true){

			if($this->Recursossolicitud_model->delete($id) == true){	

				$data = 1;	

			}else{}

		}else{}

		$this->response($data);
	}


	

}
