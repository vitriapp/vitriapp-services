<?php

declare(strict_types=1);

use services\master\Responses;
use services\master\Authentication;
use \services\set\Constant;

require_once __DIR__ . '/master/Authentication.php';
require_once __DIR__ . '/master/Responses.php';

$authentication = new Authentication();
$response = new Responses();

if (Constant::method() === Constant::POST_DATA) {
    $information = file_get_contents(Constant::PHP_INPUT);

    $array = $authentication->login($information);

    header(Constant::CONTENT_TYPE_JSON);

    if (isset($array[Constant::RESULT][Constant::ERROR_ID])) {
        $response_code = $array[Constant::RESULT][Constant::ERROR_ID];
        http_response_code((int)$response_code);
    } else {
        http_response_code(200);
    }
    echo json_encode($array);
} else {
    header(Constant::CONTENT_TYPE_JSON);
    $array = $response->methodNotAllowed();
    echo json_encode($array);
}
