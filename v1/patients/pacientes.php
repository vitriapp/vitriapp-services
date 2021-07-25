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

namespace services\v1;

use JsonException;
use services\master\Responses;
use services\master\Patients;
use services\set\Constant;

require_once '../../master/Responses.php';
require_once '../../master/Patients.php';
require_once '../../set/Constant.php';
require_once 'Get.php';

$responses = new Responses();
$patients = new Patients();
$constant = new Constant();
$data_array = '';
$information = '';
$value = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
$id_user = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

if ($constant->method() === Constant::GET_DATA) {
    $get = new Get();
    if (isset($value)) {
        $get->variousPatients((int)$value);
    } elseif (isset($id_user)) {
        $get->onePatients((int)$id_user);
    }
} elseif ($constant->method() === Constant::POST_DATA) {
    /**
     *We send data to the handler
     */
    try {
        /**
         *We receive the sent data
         */
        $information = file_get_contents(Constant::PHP_INPUT);
        $data_array = $patients->postProcess($information);
    } catch (JsonException $exception) {
        log((float)$exception);
    }
    /**
     *Let's give an answer
     */
    header(Constant::CONTENT_TYPE_JSON);
    if (isset($data_array[Constant::RESULT][Constant::ERROR_ID])) {
        $response_code = $data_array[Constant::RESULT][Constant::ERROR_ID];
        http_response_code($response_code);
    } else {
        http_response_code(200);
    }
    try {
        echo json_encode($data_array, JSON_THROW_ON_ERROR);
    } catch (JsonException $exception) {
        log((float)$exception);
    }
} elseif ($constant->method() === Constant::PUT_DATA) {
    /**
     *We send data to the handler
     */
    try {
        /**
         *We receive the sent data
         */
        $information = file_get_contents(Constant::PHP_INPUT);
        $data_array = $patients->putProcess($information);
    } catch (JsonException $exception) {
        log((float)$exception);
    }
    /**
     *Let's give an answer
     */
    header(Constant::CONTENT_TYPE_JSON);
    if (isset($data_array[Constant::RESULT][Constant::ERROR_ID])) {
        $response_code = $data_array[Constant::RESULT][Constant::ERROR_ID];
        http_response_code($response_code);
    } else {
        http_response_code(200);
    }
    try {
        echo json_encode($data_array, JSON_THROW_ON_ERROR);
    } catch (JsonException $exception) {
        log((float)$exception);
    }
} elseif ($constant->method() === Constant::DELETE_DATA) {
    $headers = getallheaders();
    if (isset($headers[Constant::TOKEN], $headers['pacienteId'])) {
        /**
         *We receive the data sent by the header
         */
        $send_data = [
            Constant::TOKEN => $headers[Constant::TOKEN],
            'pacienteId' => $headers['pacienteId']
        ];
        try {
            $information = json_encode($send_data, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            log((float)$exception);
        }
    } else {
        /**
         *We receive the sent data
         */
        $information = file_get_contents(Constant::PHP_INPUT);
    }

    /**
     *We send data to the handler
     */
    try {
        $data_array = $patients->deleteProcess($information);
    } catch (JsonException $exception) {
        log((float)$exception);
    }
    /**
     *Let's give an answer
     */
    header(Constant::CONTENT_TYPE_JSON);
    if (isset($data_array[Constant::RESULT][Constant::ERROR_ID])) {
        $response_code = $data_array[Constant::RESULT][Constant::ERROR_ID];
        http_response_code($response_code);
    } else {
        http_response_code(200);
    }
    try {
        echo json_encode($data_array, JSON_THROW_ON_ERROR);
    } catch (JsonException $exception) {
        log((float)$exception);
    }
} else {
    header(Constant::CONTENT_TYPE_JSON);
    $data_array = $responses->methodNotAllowed();
    try {
        echo json_encode($data_array, JSON_THROW_ON_ERROR);
    } catch (JsonException $exception) {
        log((float)$exception);
    }
}
