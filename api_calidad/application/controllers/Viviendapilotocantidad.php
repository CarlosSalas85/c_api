<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Viviendapilotocantidad extends REST_Controller {	

	public function __construct() {
		parent::__construct();
		$this->load->model('viviendapilotocantidad_model');
		$this->load->helper('respuesta');
	}
	

	public function find_get($id)
	{
		$datos = null;
		if(is_null($id)){
			$this->response(respuesta_api($datos));
		}

		$pendientes = 0;
		$aprobadas = 0;
		$rechazadas = 0;		
		
		$datos = $this->viviendapilotocantidad_model->cantidadSolicitudes($id);

		if(is_null($datos)){

			$datos = null;
		}

		foreach ($datos as $value) {
			
			if($value['vp_solicitudEstado'] == 1){
				$pendientes = $value['total'] + $pendientes;
			}else if($value['vp_solicitudEstado'] == 2){
				$aprobadas = $value['total'] + $aprobadas;
			}else if($value['vp_solicitudEstado'] == 3){
				$rechazadas = $value['total'] + $rechazadas;
			}
		}

		$datos = array(
			'pendientes' => $pendientes,
			'aprobadas' => $aprobadas,
			'rechazadas' => $rechazadas,
			'total' => $pendientes+$aprobadas+$rechazadas,
		);		

		$this->response(respuesta_api($datos));

	}

}
