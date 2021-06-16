<?php

declare(strict_types=1);

use services\master\Responses;
use services\master\Authentication;

require_once __DIR__ . '/master/Authentication.php';
require_once __DIR__ . '/master/Responses.php';


$_auth = new Authentication();
$_respuestas = new Responses();



if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //recibir datos
    $postBody = file_get_contents("php://input");

    //enviamos los datos al manejador
    $datosArray = $_auth->login($postBody);

    //delvolvemos una respuesta
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code((int)$responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else {
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error405();
    echo json_encode($datosArray);
}
