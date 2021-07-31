<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/7/30 8:31:34
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\v1\controller;

use JsonException;
use services\v1\General;
use services\set\Constant;

require_once '../General.php';

/**
 * Class Get for methods
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Get extends General
{

    /**
     * Show object method
     *
     * This method is useful for get method class
     *
     * @param string $method    name method dynamic
     * @param array  $arguments for search one or various results
     *
     * @return mixed
     */
    public function __call(string $method, array $arguments): int
    {
        if (str_replace('show', '', $method) === $arguments[2]) {
            $object = $this->objectClass($arguments[2]);
        } else {
            $object = null;
        }
        try {
            if ($arguments[1]) {
                ${'list'.$arguments[2]} = $object->{'list'.$arguments[2]}(
                    $arguments[0]
                );
            } else {
                ${'list'.$arguments[2]} = $object->{'get'.$arguments[2]}(
                    $arguments[0]
                );
            }
            header(Constant::CONTENT_TYPE_JSON);
            print_r(
                json_encode(
                    ${'list'.$arguments[2]},
                    JSON_THROW_ON_ERROR
                ),
                false
            );
        } catch (JsonException $exception) {
            log($exception->getMessage());
        }
        return http_response_code(200);
    }
}
