<?php
/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/7/29 9:17:18
 * @link     https://www.vitriapp.com PHP License 1.0
 */

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

namespace services\v1\error;

use JsonException;
use services\master\Responses;
use services\set\Constant;

/**
 * Class Error for Patients
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Error
{

    /**
     * Error method
     *
     * This method is useful for return some problem with get method
     *
     * @return mixed
     */
    final public function display(): string
    {
        $responses = new Responses();
        header(Constant::CONTENT_TYPE_JSON);
        header('Allow: GET, POST, PUT, DELETE');
        $dataArray = $responses->methodNotAllowed();
        try {
            print_r(json_encode($dataArray, JSON_THROW_ON_ERROR), false);
        } catch (JsonException $exception) {
            log($exception->getMessage());
        }
        return '';
    }

    /**
     * Not found method
     *
     * This method is useful for return some problem with get data
     *
     * @return mixed
     */
    final public function notFound(): string
    {
        $responses = new Responses();
        header(Constant::CONTENT_TYPE_JSON);
        $dataArray = $responses->internalError();
        try {
            print_r(json_encode($dataArray, JSON_THROW_ON_ERROR), false);
        } catch (JsonException $exception) {
            log($exception->getMessage());
        }
        return '';
    }
}
