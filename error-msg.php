<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/7/28 6:3:13
 * @link     https://www.vitriapp.com PHP License 1.0
 */

header('HTTP/1.0 404 Not Found');
header('Status: 404 Not Found');
header('Content-Type:application/json;charset=utf-8');
http_response_code(404);

$response['status'] = 'Error';
$response['result'] = array(
    'error_id' => '404',
    'error_msg' => 'No encontramos el recurso solicitado.'
);

try {
    print_r(
        json_encode(
            $response,
            JSON_THROW_ON_ERROR | 512,
            JSON_THROW_ON_ERROR
        ),
        false
    );
} catch (JsonException $exception) {
    log($exception->getMessage());
}
