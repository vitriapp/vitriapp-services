<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/6/14 0:19:41
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services;

use JsonException;
use services\master\Authentication;
use services\master\Responses;
use \services\set\Constant;

require_once 'master/Authentication.php';
require_once 'master/Responses.php';
require_once 'set/Constant.php';

$authentication = new Authentication();
$response = new Responses();
$constant = new Constant();

if ($constant->method() === Constant::POST_DATA) {
    $array =  '';
    try {
        $information = file_get_contents(Constant::PHP_INPUT);
        $array = $authentication->login($information);
    } catch (JsonException $exception) {
        log($exception->getMessage());
    }

    header(Constant::CONTENT_TYPE_JSON);

    if (isset($array[Constant::RESULT][Constant::ERROR_ID])) {
        $response_code = $array[Constant::RESULT][Constant::ERROR_ID];
        http_response_code((int)$response_code);
    } else {
        http_response_code(200);
    }
    try {
        print_r(json_encode($array, JSON_THROW_ON_ERROR), false);
    } catch (JsonException $exception) {
        log($exception->getMessage());
    }
} else {
    header(Constant::CONTENT_TYPE_JSON);
    $array = $response->methodNotAllowed();
    try {
        print_r(json_encode($array, JSON_THROW_ON_ERROR), false);
    } catch (JsonException $exception) {
        log($exception->getMessage());
    }
}
