<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class solicitudes extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('solicitudes_model');
		$this->load->helper('respuesta');
	}

	public function find_get($id)
	{

		$datos = $this->solicitudes_model->getDetalle($id);

		if (is_null($datos)) {
			$datos = '';
		}
		$this->response(respuesta_api($datos));
	}

	public function index_post()
	{

		$datos = '';

		$data_uno = array(
			'Solicitud_cantidad' => $this->post('Cantidad'),
			'Solicitud_Total' => $this->post('Total'),
			'SolicitudCantidad_enOrden' => $this->post('cantidad_orden'),
			'SolicitudCantidad_porComprar' => $this->post('cantidad_porcomp'),
			'SolicitudCantidad_recepcion' => $this->post('cantidad_recep'),
			'SolicitudUltimo_precio' => $this->post('ultimo_precio'),
			'SolicitudArchivo' => $this->post('archivo'),
			'SolicitudJustificacion' => $this->post('justificacion'),
			'SolicitudRecurso_codigo' => $this->post('Recurso'),
			'SolicitudRecurso_nombre' => $this->post('Descripcion'),
			'SolicitudRecurso_unidad' => $this->post('Unidad'),
			'Causales_idCausales' => $this->post('sobreConsumo'),
			'Obra_idObra' => $this->post('idObra'),
			'Solicitud_estado' => $this->post('estado'),
		);

		$data_dos =  array(
			'Solicitud_estadosFecha' => $this->post('fecha'),
			'idUsuario' => $this->post('usuario'),
			'Solicitud_estadosEstado' => $this->post('estado'),
			'Solicitud_estadosNueva_cantidad' => $this->post('nueva_cantidad'),
			'Solicitud_estadosNuevo_total' => $this->post('desviacion'),
		);

		$data_tres = array(
			'Solicitud_recursoCodigo' => $this->post('RecursoAnterior'),
			'Solicitud_recursoDescripcion' => $this->post('DescripcionAnterior'),
			'Solicitud_recursoUnidad' => $this->post('UnidadAnterior'),
			'Solicitud_recursoCantidad' => $this->post('CantidadAnterior'),
			'Solicitud_recursoPrecio' => $this->post('TotalAnterior'),
		);

		$id_solicitud = $this->solicitudes_model->save_solicitud($data_uno);

		if ($this->post('sobreConsumo') == 5) {
			$this->solicitudes_model->save_solicitudRecurso($data_tres, $id_solicitud);
		}

		if (!is_null($id_solicitud)) {

			$id_solicitudEstados = $this->solicitudes_model->save_solicitudEstados($data_dos, $id_solicitud);

			if (!is_null($id_solicitudEstados)) {

				$datos = array('id' => $id_solicitud);
			} else { }
		} else { }

		$this->response(respuesta_api($datos));
	}

	public function index_delete($id)
	{
		$datos = '';
		if (is_null($id)) {
			$this->response(respuesta_api($datos));
		}

		if ($this->solicitudes_model->eliminarSolicitud($id) == TRUE) {
			$datos = array('id' => $id);
		}
		$this->response(respuesta_api($datos));
	}

	public function index_put($id)
	{
		$datos = '';
		if (is_null($id)) {
			$this->response(respuesta_api($datos));
		}

		$id_solicitud =  $this->put('id');

		$data_uno = array(
			'SolicitudObservacion' => $this->put('observacion'),
			'SolicitudEstado' => $this->put('estado'),
			'SolicitudNumero_orden' => $this->put('n_orden')
		);

		$data_dos =  array(
			'Solicitud_estadosFecha' => $this->put('fecha'),
			'idUsuario' => $this->put('usuario'),
			'Solicitud_estadosEstado' => $this->put('estado'),
			'Solicitud_estadosNueva_cantidad' => $this->put('nuevaCantidad'),
			'Solicitud_estadosNuevo_total' => $this->put('nuevoPrecio'),
		);

		if ($this->solicitudes_model->actualizarSolicitud($id_solicitud, $data_uno) == TRUE) {
			$datos = array(
				'id' => $this->solicitudes_model->save_solicitudEstados($data_dos, $id_solicitud)
			);
		}

		$this->response(respuesta_api($datos));
	}
}
