<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Solicitudesreportes extends REST_Controller {	

	public function __construct() {
		parent::__construct();
		$this->load->model('Solicitudesreportes_model');
	}

	public function find_get($id){

		if(!$id){
			$this->response(null,400);
		}

		switch ($id) {	

			case '1':
			$data = $this->Solicitudesreportes_model->getAll();
			break;			
			case '6':
			$data = $this->Solicitudesreportes_model->getAllEstado($id);
			break;
			case '7':
			$data = $this->Solicitudesreportes_model->getAllEstado($id);
			break;
			case '8':
			$data = $this->Solicitudesreportes_model->getAllEstado($id);
			break;
			case '9':
			$data = $this->Solicitudesreportes_model->getAllEstado($id);
			break;

			default:			 
			$data = $this->Solicitudesreportes_model->getAllObra($id);
			break; 
		}

		$this->response($data);			
	}	

}
