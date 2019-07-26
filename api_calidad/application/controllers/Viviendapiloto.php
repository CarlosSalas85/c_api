<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Viviendapiloto extends REST_Controller {	

	public function __construct() {
		parent::__construct();
		$this->load->model('viviendapiloto_model');
		$this->load->helper('respuesta');
	}
	

	public function index_post(){
		$datos = '';
		if(!$this->post('Obra_idObra')){
			$this->response(respuesta_api($datos));
		}

		$data = array(
			'Obra_idObra' => $this->post('Obra_idObra'),
			'estado' => $this->post('estado'),
			'DescripcionRecurso' => $this->post('DescripcionRecurso'),
			'CodigoUnidad' => $this->post('CodigoUnidad'),
			'CantidadRecursoActividad' => $this->post('CantidadRecursoActividad'),
			'PrecioRecurso' => $this->post('PrecioRecurso'),
			'CodigoActividad' => $this->post('CodigoActividad'),
			'CodigoRecurso' => $this->post('CodigoRecurso'),	
		);

		$data_dos = array(						
			'usuario' => $this->post('usuario'),
			'fecha' => $this->post('fecha'),
			'estado' => $this->post('estado'),			
			'nuevaCantidad' => $this->post('nuevaCantidad'),
			'nuevoPrecio' => $this->post('nuevoPrecio'),
		);

		$id_solicitud = $this->viviendapiloto_model->save_vpSolicitud($data);

		if(!is_null($id_solicitud)){

			$id_estado = $this->viviendapiloto_model->save_vpEstado($data_dos, $id_solicitud);

			if(!is_null($id_estado)){

				$datos = $id_estado;
			}else{
				$datos = 0;
			}
		}
		else{
			$datos = 0;
		}
		
		$this->response(respuesta_api($datos));
		
	}

	public function find_get($id)
	{
		$datos = '';
		
		if(!$id){
			$this->response(respuesta_api($datos));
		}

		$datos = explode("-", $id);
		$idObra = $datos[0];
		$idEstado = $datos[1];
		$idUsuario = $datos[2];

		$datos = $this->viviendapiloto_model->obtenerSolicitudes($idObra, $idEstado,$idUsuario);	
		
	    for ($i=0; $i < count($datos); $i++) {			
			array_push($datos[$i], $this->viviendapiloto_model->proyecto($datos[$i]['idObra']));
			array_push($datos[$i], $this->viviendapiloto_model->usuario($datos[$i]['idUsuario']));		
		}

		if(empty($datos)){

			$datos = null;
		}		

		$this->response(respuesta_api($datos));	

	}

	public function index_delete($id){
		$datos = '';
		if(is_null($id)){	
			$this->response(respuesta_api($datos));		
		}
		
		if($this->viviendapiloto_model->eliminarSolicitud($id)== TRUE){
			$datos = array('id' => $id);
		}
		$this->response(respuesta_api($datos));	
	}

	public function index_put($id){
		$datos = '';
		if(is_null($id)){	
			$this->response(respuesta_api($datos));	
		}

		$id_solicitud =  $this->put('id');

		$data_dos = array(			
			'nuevaCantidad' => $this->put('nuevaCantidad'),
			'nuevoPrecio' => $this->put('nuevoPrecio'),
			'estado' => $this->put('estado'),
			'fecha' => $this->put('fecha'),
			'usuario' => $this->put('usuario'),   
		);		

		if($this->viviendapiloto_model->actualizarVpSolicitud($id_solicitud, $data_dos) == TRUE){
			$datos = array (
			'id' => $datos = $this->viviendapiloto_model->save_vpEstado($data_dos, $id_solicitud)
			);
		}	
			
		$this->response(respuesta_api($datos));
	}
	
}
