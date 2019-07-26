<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Solicitudesrecurso extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('solicitudes_model');
		$this->load->helper('respuesta');
	}

	public function find_get($id)
	{

		$datos = $this->solicitudes_model->getRecurso($id);
		if (is_null($datos)) {
			$datos = '';
		}

		$this->response(respuesta_api($datos));
	}
}
