<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class RecursossolicitudDetalle extends REST_Controller {	

	public function __construct() {
		parent::__construct();
	    $this->load->model('Recursossolicitud_model');
	}

	public function find_get($id){

		if(!$id){
			$this->response(null,400);
		}	

		$data = $this->Recursossolicitud_model->detalle($id);
		$this->response($data);
	}

	

}
