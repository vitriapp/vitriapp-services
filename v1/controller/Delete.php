<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/7/30 8:31:22
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\v1\controller;

use JsonException;
use services\set\Constant;
use services\v1\General;

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
     * @param string $method    name method dynamic
     * @param array  $arguments for search one or various results
     *
     * @return mixed
     * @throws JsonException
     */
    final public function __call(string $method, array $arguments): string
    {
        $headers = getallheaders();
        $general = new General();
        $validator = $general->objectClass(
            str_replace(
                'remove',
                '',
                $method
            ),
            'delete'
        );
        $information = file_get_contents(Constant::PHP_INPUT);
        if (isset($headers[Constant::TOKEN], $headers['id'])) {
            $sendData = [
                Constant::TOKEN => $headers[Constant::TOKEN],
                'id' => $headers['id']
            ];
            $information = json_encode($sendData, JSON_THROW_ON_ERROR);
        }
        $dataArray = $validator->actionProcess(
            $information,
            'delete',
            $arguments[0]
        );
        header(Constant::CONTENT_TYPE_JSON);
        if (isset($dataArray[Constant::RESULT][Constant::ERROR_ID])) {
            $responseCode = $dataArray[Constant::RESULT][Constant::ERROR_ID];
            http_response_code($responseCode);
        }
        http_response_code(200);
        try {
            print_r(json_encode($dataArray, JSON_THROW_ON_ERROR), false);
        } catch (JsonException $exception) {
            log($exception->getMessage());
        }
        return '';
    }
}
