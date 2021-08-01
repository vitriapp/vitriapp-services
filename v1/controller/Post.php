<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/7/30 8:31:16
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\v1\controller;

use JsonException;
use services\set\Constant;
use services\v1\model\Patients;

require_once '../model/Patients.php';

/**
 * Class Post for Patients
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Post
{

    /**
     * Add patients method for patients
     *
     * This method is useful for insert patients
     *
     * @return mixed
     */
    final public function addPatients(): string
    {
        $dataArray = '';
        try {
            $patients = new Patients();
            $information = file_get_contents(Constant::PHP_INPUT);
            $dataArray = $patients->actionProcess($information, 'post');
        } catch (JsonException $exception) {
            log($exception->getMessage());
        }
        header(Constant::CONTENT_TYPE_JSON);
        if (isset($dataArray[Constant::RESULT][Constant::ERROR_ID])) {
            $responseCode = $dataArray[Constant::RESULT][Constant::ERROR_ID];
            http_response_code($responseCode);
        }
        http_response_code(200);
        try {
            print_r(json_encode($dataArray, JSON_THROW_ON_ERROR), false);
        } catch (JsonException $exception) {
            log((float)$exception->getTrace());
        }
        return '';
    }
}
