<?php
defined('BASEPATH') or exit('No direct script access allowed');


function respuesta_api($datos)
{

    if (!is_null($datos)) {

        return array(
            'estatus' => 200,
            'mensaje' => 'Si hay datos',
            'registros' => count($datos),
            'datos' => $datos
        );
    } else {
        return array(
            'estatus' => 400,
            'mensaje' => 'No hay datos',
            'registros' => 0, 'datos' => null
        );
    }
}
