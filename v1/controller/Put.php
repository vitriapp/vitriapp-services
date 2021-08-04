<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/7/30 8:30:58
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\v1\controller;

use JsonException;
use services\set\Constant;
use services\v1\General;

require_once '../Validator.php';

/**
 * Class Put for Patients
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Put
{

    /**
     * Edit patients method for patients
     *
     * This method is useful for edit information patients
     *
     * @param string $method    name method dynamic
     * @param array  $arguments for search one or various results
     *
     * @return mixed
     */
    final public function __call(string $method, array $arguments): string
    {
        $general = new General();
        $validator = $general->objectClass(str_replace('edit', '', $method), 'put');
        $information = file_get_contents(Constant::PHP_INPUT);
        $dataArray = $validator->actionProcess($information, 'put', $arguments[0]);
        header(Constant::CONTENT_TYPE_JSON);
        if (isset($dataArray[Constant::RESULT][Constant::ERROR_ID])) {
            $responseCode = $dataArray[Constant::RESULT][Constant::ERROR_ID];
            http_response_code($responseCode);
        }
        http_response_code(200);
        try {
            print_r(json_encode($dataArray, JSON_THROW_ON_ERROR), false);
        } catch (JsonException $exception) {
            log($exception->getCode());
        }
        return '';
    }
}
