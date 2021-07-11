<?php

declare(strict_types=1);

namespace services\v1;

/**
 * *
 *  * PHP version 7.4
 *  *
 *  * @Date: 2021/6/14 4:14:58
 *  * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 *  * @category Developer
 *  * @package  Vitriapp
 *  * @license  Commercial
 *
 */

use services\master\Responses;
use services\master\Patients;
use services\set\Constant;

require_once __DIR__ . '/../set/Constant.php';
require_once __DIR__ . '/../master/Patients.php';

$responses = new Responses();
$patients = new Patients();

if (Constant::method() === Constant::GET_DATA) {
    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
        $listaPacientes = $patients->listaPacientes($pagina);
        header(Constant::CONTENT_TYPE_JSON);
        echo json_encode($listaPacientes);
        http_response_code(200);
    } elseif (isset($_GET['id'])) {
        $pacienteid = $_GET['id'];
        $datosPaciente = $patients->obtenerPaciente($pacienteid);
        header(Constant::CONTENT_TYPE_JSON);
        echo json_encode($datosPaciente);
        http_response_code(200);
    }
} elseif (Constant::method() === Constant::POST_DATA) {
    //recibimos los datos enviados
    $information = file_get_contents(Constant::PHP_INPUT);
    //enviamos los datos al manejador
    $data_array = $patients->post($information);
    //delvovemos una respuesta
    header(Constant::CONTENT_TYPE_JSON);
    if (isset($data_array[Constant::RESULT][Constant::ERROR_ID])) {
        $response_code = $data_array[Constant::RESULT][Constant::ERROR_ID];
        http_response_code($response_code);
    } else {
        http_response_code(200);
    }
    echo json_encode($data_array);
} elseif (Constant::method() === Constant::PUT_DATA) {
    //recibimos los datos enviados
    $information = file_get_contents(Constant::PHP_INPUT);
    //enviamos datos al manejador
    $data_array = $patients->put($information);
    //delvovemos una respuesta
    header(Constant::CONTENT_TYPE_JSON);
    if (isset($data_array[Constant::RESULT][Constant::ERROR_ID])) {
        $response_code = $data_array[Constant::RESULT][Constant::ERROR_ID];
        http_response_code($response_code);
    } else {
        http_response_code(200);
    }
    echo json_encode($data_array);
} elseif (Constant::method() === Constant::DELETE_DATA) {
    $headers = getallheaders();
    if (isset($headers[Constant::TOKEN]) && isset($headers["pacienteId"])) {
        //recibimos los datos enviados por el header
        $send_data = [
            Constant::TOKEN => $headers[Constant::TOKEN],
            "pacienteId" => $headers["pacienteId"]
        ];
        $information = json_encode($send_data);
    } else {
        //recibimos los datos enviados
        $information = file_get_contents(Constant::PHP_INPUT);
    }

    //enviamos datos al manejador
    $data_array = $patients->delete($information);
    //delvovemos una respuesta
    header(Constant::CONTENT_TYPE_JSON);
    if (isset($data_array[Constant::RESULT][Constant::ERROR_ID])) {
        $response_code = $data_array[Constant::RESULT][Constant::ERROR_ID];
        http_response_code($response_code);
    } else {
        http_response_code(200);
    }
    echo json_encode($data_array);
} else {
    header(Constant::CONTENT_TYPE_JSON);
    $data_array = $responses->methodNotAllowed();
    echo json_encode($data_array);
}
