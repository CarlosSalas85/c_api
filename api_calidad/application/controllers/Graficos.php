<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Graficos extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('graficos_model');
		$this->load->helper('respuesta');
	}


	public function find_get($id)
	{
		$datos = '';
		if (!$id) {
			$this->response(respuesta_api($datos));
		}

		$valores = explode("-", $id);
		$grafico = $valores[0];
		$obra = $valores[1];

		switch ($grafico) {

			case '1': //contador Causales

				if ($obra != 0) { //contador Causales por Obra

					$data = $this->graficos_model->valoresCausalesObra($obra);
				} else { //contador Causales de todas las Obras

					$data = $this->graficos_model->valoresCausalesAll();
				}
				if (!empty($data)) {
					$datos = $data;
				} else {
					$datos = null;
				}

				break;

			case '2': //Top Recursos

				if ($obra != 0) { //Top Recursos por Obra

					$data = $this->graficos_model->valoresTopRecursosObra($obra);
				} else { //Top Recursos de todas las Obras

					$data = $this->graficos_model->valoresTopRecursosAll();
				}

				if (!empty($data)) {
					$datos = $data;
				} else {
					$datos = null;
				}

				break;

			case '3': //Desviacion

				if ($obra != 0) { //Total Desviacion

					$data = $this->graficos_model->valorDesviacionObra($obra);
				} else { //Desviacion por Obra

					$data = $this->graficos_model->valorDesviacionAll();
				}

				break;

			case '4': //Tiempo Pendiente-Aprobado 
				if ($obra != 0) { //Total Pendiente-Aprobado

				} else { //Tiempo Pendiente-Aprobado Perfil

					$data = $this->graficos_model->solicitudes();
					$resultado = [];

					foreach ($data as $key => $value) {

						$fechaPend = $this->graficos_model->fechaSolicitud($value['idSolicitud'], 1);

						if (!empty($fechaPend)) {

							foreach ($fechaPend as $key => $row) {
								$fechaPend2 = new DateTime($row['Solicitud_estadosFecha']);
							}

							$fechaApro = $this->graficos_model->fechaSolicitud($value['idSolicitud'], 2);

							if (!empty($fechaApro)) {

								foreach ($fechaApro as $key => $row2) {
									$fechaApro2 = new DateTime($row2['Solicitud_estadosFecha']);
								}

								$dias = $fechaPend2->diff($fechaApro2);

								$resultado[] = array(
									'causal' => $value['Causales_idCausales'],
									'dias' => $dias->days,
								);
							}
						}
					}

					$datos = $this->_dias($resultado);
					//$datos = $resultado;
				}

				break;

			case '5': //Tiempo Aprobado-Cierre 				

				if ($obra != 0) { //Total Pendiente-Aprobado

				} else { //Tiempo Pendiente-Aprobado Perfil

					$data = $this->graficos_model->solicitudes();
					$resultado = [];

					foreach ($data as $key => $value) {

						$fechaPend = $this->graficos_model->fechaSolicitud($value['idSolicitud'], 2);

						if (!empty($fechaPend)) {

							foreach ($fechaPend as $key => $row) {
								$fechaPend2 = new DateTime($row['Solicitud_estadosFecha']);
							}

							$fechaApro = $this->graficos_model->fechaSolicitud($value['idSolicitud'], 4);

							if (!empty($fechaApro)) {

								foreach ($fechaApro as $key => $row2) {
									$fechaApro2 = new DateTime($row2['Solicitud_estadosFecha']);
								}

								$dias = $fechaPend2->diff($fechaApro2);

								$resultado[] = array(
									'causal' => $value['Causales_idCausales'],
									'dias' => $dias->days,
								);
							}
						}
					}

					$datos = $this->_dias($resultado);
					//$datos = $resultado;
				}

				break;


			case '6': //TotalSolicitudes

				if ($obra != 0) { //TotalSolicitudes por Obra
					$data = $this->graficos_model->totalSolicitudesObra($obra);
				} else { //TotalSolicitudes
					$data = $this->graficos_model->totalSolicitudes();
				}

				if (!empty($data)) {
					$datos = $data;
				} else {
					$datos = null;
				}
				break;
			default:
				$data = '';
				break;
		}

		$this->response(respuesta_api($datos));
	}

	private function _dias($resultado)
	{
		$count1 = 0;
		$count2 = 0;
		$count3 = 0;
		$count4 = 0;
		$count5 = 0;
		$count6 = 0;

		$dias1Neto = 0;
		$dias2Neto = 0;
		$dias3Neto = 0;
		$dias4Neto = 0;
		$dias5Neto = 0;
		$dias6Neto = 0;

		$causal1 = 'ROBO O HURTO';
		$causal2 = 'RECURSO NO PRESUPUESTADO';
		$causal3 = 'MAYOR CANTIDAD RECURSO';
		$causal4 = 'MERMAS DE BODEGA';
		$causal5 = 'CAMBIO DE RECURSO';
		$causal6 = 'PRESUPUESTO NO EN CONTROL ';

		foreach ($resultado as $key => $valor) {

			switch ($valor['causal']) {

				case '1':
					$count1++;
					$dias1Neto = round(($valor['dias'] + $dias1Neto));
					break;

				case '2':
					$count2++;
					$dias2Neto = round(($valor['dias'] + $dias2Neto));
					break;

				case '3':
					$count3++;
					$dias3Neto = round(($valor['dias'] + $dias3Neto));
					break;

				case '4':
					$count4++;
					$dias4Neto = round(($valor['dias'] + $dias4Neto));
					break;

				case '5':
					$count5++;
					$dias5Neto = round(($valor['dias'] + $dias5Neto));
					break;

				case '6':
					$count6++;
					$dias6Neto = round(($valor['dias'] + $dias6Neto));
					break;
			}
		}

		if ($count1 != 0) {
			$dias1Neto = round($dias1Neto / $count1);
		}
		if ($count2 != 0) {
			$dias2Neto = round($dias2Neto / $count2);
		}
		if ($count3 != 0) {
			$dias3Neto = round($dias3Neto / $count3);
		}
		if ($count4 != 0) {
			$dias4Neto = round($dias4Neto / $count4);
		}
		if ($count5 != 0) {
			$dias5Neto = round($dias5Neto / $count5);
		}
		if ($count6 != 0) {
			$dias6Neto = round($dias6Neto / $count6);
		}

		$informacion = array(

			'causal1' => $causal1,
			'dias1Neto' => $dias1Neto,

			'causal2' => $causal2,
			'dias2Neto' => $dias2Neto,

			'causal3' => $causal3,
			'dias3Neto' => $dias3Neto,

			'causal4' => $causal4,
			'dias4Neto' => $dias4Neto,

			'causal5' => $causal5,
			'dias5Neto' => $dias5Neto,

			'causal6' => $causal6,
			'dias6Neto' => $dias6Neto,
		);

		return $informacion;
	}
}
