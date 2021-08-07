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
use services\v1\General;

require_once '../Validator.php';
require_once '../../master/Responses.php';
require_once '../../master/connection/Executor.php';

/**
 * Class PostPutDelete
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class PostPutDelete
{
    /**
     * Request method
     *
     * This method is useful for request post, put and delete
     *
     * @param string $method    name method dynamic
     * @param array  $arguments for search one or various results
     *
     * @return mixed
     * @throws JsonException
     */
    final public function __call(string $method, array $arguments): string
    {
        $general = new General();
        $validator=$general->objectClass($arguments[1], strtolower($arguments[2]));
        $information = file_get_contents(Constant::PHP_INPUT);
        $headers = getallheaders();

        if (isset($headers[Constant::TOKEN], $headers['id'])
            && $arguments[2] === 'DELETE'
            && $method === 'request'
        ) {
            $sendData = [
                Constant::TOKEN => $headers[Constant::TOKEN],
                'id' => $headers['id']
            ];
            $information = json_encode($sendData, JSON_THROW_ON_ERROR);
        }

        $dataArray = $validator->actionProcess(
            $information,
            strtolower($arguments[2]),
            $arguments[1]
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
