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

namespace services\v1\patients;

use JsonException;
use services\set\Constant;

/**
 * Class Delete for Patients
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Delete
{

    /**
     * Remove patients method for patients
     *
     * This method is useful for remove information patients
     *
     * @return mixed
     */
    final public function removePatients(): string
    {
        $dataArray = '';
        $information = '';
        $headers = getallheaders();
        $patients = new Patients();
        if (isset($headers[Constant::TOKEN], $headers['pacienteId'])) {
            $send_data = [
                Constant::TOKEN => $headers[Constant::TOKEN],
                'pacienteId' => $headers['pacienteId']
            ];
            try {
                $information = json_encode($send_data, JSON_THROW_ON_ERROR);
            } catch (JsonException $exception) {
                log($exception->getMessage());
            }
        } else {
            $information = file_get_contents(Constant::PHP_INPUT);
        }
        try {
            $dataArray = $patients->deleteProcess($information);
        } catch (JsonException $exception) {
            log($exception->getMessage());
        }
        header(Constant::CONTENT_TYPE_JSON);
        if (isset($dataArray[Constant::RESULT][Constant::ERROR_ID])) {
            $response_code = $dataArray[Constant::RESULT][Constant::ERROR_ID];
            http_response_code($response_code);
        } else {
            http_response_code(200);
        }
        try {
            print_r(json_encode($dataArray, JSON_THROW_ON_ERROR), false);
        } catch (JsonException $exception) {
            log($exception->getMessage());
        }
        return '';
    }
}
