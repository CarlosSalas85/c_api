<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Solicitudestados extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('solicitudestados_model');
		$this->load->model('solicitudes_model');
		$this->load->model('viviendapiloto_model');
		$this->load->helper('respuesta');
	}

	public function find_get($id)
	{
		$datos = '';
		if (!$id) {
			$datos = '';
		}

		$valores = explode("-", $id);
		$perfil = $valores[0];
		$obra = $valores[1];
		$estado = $valores[2];
		$idUsuario = $valores[3];

		if ($obra != 0) {

			switch ($perfil) {
				case '4':
					$datos = $this->solicitudestados_model->getCentroCostoAo($estado, $obra, $idUsuario);
					break;
				case '5':
					$datos = $this->solicitudestados_model->getCentroCostoPgr($estado, $obra);
					break;
				case '35':
					$datos = $this->solicitudestados_model->getCentroCostoPrevencion($estado, $obra);
					break;
				case '34':
					$datos = $this->solicitudestados_model->getCentroCostoPresupuesto($estado, $obra);
					break;

				default:
					$datos = $this->solicitudestados_model->getCentroCosto($estado, $obra);
					break;
			}
		} else {

			switch ($perfil) {
				case '4':
					$datos = $this->solicitudestados_model->getAllAo($estado, $idUsuario);
					break;
				case '5':
					$datos = $this->solicitudestados_model->getAllPgr($estado);
					break;
				case '35':
					$datos = $this->solicitudestados_model->getAllPrevencion($estado);
					break;
				case '34':
					$datos = $this->solicitudestados_model->getAllPresupuesto($estado);
					break;
					
				default:
					$datos = $this->solicitudestados_model->getAll($estado);
					break;
			}
		}

		if (!empty($datos)) {
			for ($i = 0; $i < count($datos); $i++) {
				array_push($datos[$i], $this->viviendapiloto_model->proyecto($datos[$i]['idObra']));
				array_push($datos[$i], $this->viviendapiloto_model->usuario($datos[$i]['idUsuario']));
			}
		} else {
			$datos = null;
		}

		$this->response(respuesta_api($datos));
	}
}
