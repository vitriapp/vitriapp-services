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
 *  * @license  Comercial
 *
 */

use services\master\Responses;
use services\master\Patients;
use services\set\Sets;

require_once __DIR__.'/../set/Sets.php';
require_once __DIR__.'/../master/Patients.php';

$responses = new Responses();
$patients = new Patients();


if (Sets::method() === 'GET') {
    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
        $listaPacientes = $patients->listaPacientes($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaPacientes);
        http_response_code(200);
    } elseif (isset($_GET['id'])) {
        $pacienteid = $_GET['id'];
        $datosPaciente = $patients->obtenerPaciente($pacienteid);
        header("Content-Type: application/json");
        echo json_encode($datosPaciente);
        http_response_code(200);
    }
} elseif (Sets::method() === 'POST') {
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos los datos al manejador
    $datosArray = $patients->post($postBody);
    //delvovemos una respuesta
     header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
     echo json_encode($datosArray);
} elseif (Sets::method() === 'PUT') {
      //recibimos los datos enviados
      $postBody = file_get_contents("php://input");
      //enviamos datos al manejador
      $datosArray = $patients->put($postBody);
        //delvovemos una respuesta
     header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
     echo json_encode($datosArray);
} elseif (Sets::method() === 'DELETE') {
        $headers = getallheaders();
    if (isset($headers["token"]) && isset($headers["pacienteId"])) {
        //recibimos los datos enviados por el header
        $send = [
            "token" => $headers["token"],
            "pacienteId" =>$headers["pacienteId"]
        ];
        $postBody = json_encode($send);
    } else {
        //recibimos los datos enviados
        $postBody = file_get_contents("php://input");
    }
        
        //enviamos datos al manejador
        $datosArray = $patients->delete($postBody);
        //delvovemos una respuesta
        header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
        echo json_encode($datosArray);
} else {
    header('Content-Type: application/json');
    $datosArray = $responses->error405();
    echo json_encode($datosArray);
}
