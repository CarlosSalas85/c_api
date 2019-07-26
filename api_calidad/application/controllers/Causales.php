<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Causales extends REST_Controller {	

	public function __construct() {
		parent::__construct();
		$this->load->model('causales_model');
		$this->load->helper('respuesta');
	}

	
	public function index_get()
	{
		$datos = null;
		$datos = $this->causales_model->get();

		if(!is_null($datos)){
			$this->response(respuesta_api($datos));
		}else{
			$this->response(respuesta_api($datos));
		}
	}

	public function find_get($id)
	{
		if(!$id){
			$this->response(null,400);
		}
		$datos = $this->causales_model->get($id);

		if(!is_null($datos)){
			$this->response($datos,200);
		}else{
			$this->response(array(''), 404);
		}

	}

	public function index_post(){
		if(!$this->post('CausalesNombre')){
			$this->response(null,400);
		}

		$data = array('CausalesNombre' => mb_strtoupper($this->post('CausalesNombre')),
			'CausalesRequisito' => ucfirst(strtolower($this->post('CausalesRequisito'))),
			'CausalesTipo' => mb_strtoupper($this->post('CausalesTipo')),); 

		if($this->causales_model->validate($data) === true){

			$this->response(array(0));

		}else{

			$id = $this->causales_model->save($data);

			if(!is_null($id)){
				$this->response(array($id),200);
			}else{
				$this->response(array('error' => 'no', 400));
			}
		}
		
	}

	public function index_put($id){
		$data = array('CausalesNombre' => mb_strtoupper($this->put('CausalesNombre')),
			'CausalesRequisito' => ucfirst(strtolower($this->put('CausalesRequisito'))),
			'CausalesTipo' => mb_strtoupper($this->put('CausalesTipo')),);
		

		$update = $this->causales_model->update($id, $data);

		if(!is_null($update)){
			$this->response(array('si'),200);
		}else{
			$this->response(array('no', 400));
		}

		
	}

	public function index_delete($id){
		if(!is_null($id)){
			//$this->response(array('response' => $id),200);
		}

		$delete = $this->causales_model->delete($id);

		if(!is_null($delete)){
			$this->response(array('si'),200);
		}else{
			$this->response(array('no', 400));
		}		
	}

	
}
