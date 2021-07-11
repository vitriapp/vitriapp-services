<?php

declare(strict_types=1);

use services\master\Responses;
use services\master\Authentication;
use \services\set\Servicesset;

require_once __DIR__ . '/master/Authentication.php';
require_once __DIR__ . '/master/Responses.php';

$authentication = new Authentication();
$response = new Responses();

if (Servicesset::method() === Servicesset::POST_DATA) {
    $information = file_get_contents(Servicesset::PHP_INPUT);

    $array = $authentication->login($information);

    header(Servicesset::CONTENT_TYPE_JSON);

    if (isset($array[Servicesset::RESULT][Servicesset::ERROR_ID])) {
        $response_code = $array[Servicesset::RESULT][Servicesset::ERROR_ID];
        http_response_code((int)$response_code);
    } else {
        http_response_code(200);
    }
    echo json_encode($array);
} else {
    header(Servicesset::CONTENT_TYPE_JSON);
    $array = $response->methodNotAllowed();
    echo json_encode($array);
}
