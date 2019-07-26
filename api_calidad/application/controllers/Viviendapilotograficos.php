<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Viviendapilotograficos extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('viviendapilotograficos_model');
		$this->load->helper('respuesta');
	}


	public function find_get($id)
	{
		$datos = '';
		if (is_null($id)) {
			$this->response(respuesta_api($datos));
		}
		$data = explode("-", $id);

		$idGrafico = $data[0];
		$idObra = $data[1];

		switch ($idGrafico) {
			case '1':
				$datos = $this->viviendapilotograficos_model->topRecursos($idObra);
				break;

			case '2':
				$datos = $this->viviendapilotograficos_model->topActividades($idObra);
				break;

			default:

				break;
		}
		$this->response(respuesta_api($datos));
	}
}
