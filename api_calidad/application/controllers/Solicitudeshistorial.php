<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Solicitudeshistorial extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('solicitudes_model');
        $this->load->model('viviendapiloto_model');
        $this->load->helper('respuesta');
    }

    public function find_get($id)
    {
        $datos = $this->solicitudes_model->getHistorial($id);
        if (is_null($datos)) {
            $datos = '';
        } else {
           for ($i = 0; $i < count($datos); $i++) {
                array_push($datos[$i], $this->viviendapiloto_model->usuario($datos[$i]['idUsuario']));
            }
        }

        $this->response(respuesta_api($datos));
    }
}
