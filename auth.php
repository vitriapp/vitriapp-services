<?php

declare(strict_types=1);

use services\master\Responses;
use services\master\Authentication;
use \services\set\Sets;

require_once __DIR__ . '/master/Authentication.php';
require_once __DIR__ . '/master/Responses.php';

$authentication = new Authentication();
$response = new Responses();

if (Sets::method() === Sets::POST_DATA) {
    $information = file_get_contents(Sets::PHP_INPUT);

    $array = $authentication->_login($information);

    header(Sets::CONTENT_TYPE_JSON);

    if (isset($array[Sets::RESULT][Sets::ERROR_ID])) {
        $response_code = $array[Sets::RESULT][Sets::ERROR_ID];
        http_response_code((int)$response_code);
    } else {
        http_response_code(200);
    }
    echo json_encode($array);
} else {
    header(Sets::CONTENT_TYPE_JSON);
    $array = $response->methodNotAllowed();
    echo json_encode($array);
}
