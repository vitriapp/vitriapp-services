<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/7/30 11:46:23
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\v1;

use JsonException;
use services\master\connection\Executor;
use services\master\Responses;
use services\set\Regular;

/**
 * Class General
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class General
{

    /**
     * Method
     *
     * This method is useful for use some required method
     *
     * @param string $method name to use.
     *
     * @return string
     */
    final public function method(string $method): string
    {
        $result = new Regular();
        return $result->results($method);
    }

    /**
     * Object select class
     *
     * This method is useful for get method class
     *
     * @param string $object name object class
     * @param string $action name action method
     *
     * @return object
     */
    final public function objectClass(string $object, string $action): object
    {
        if ($action === 'get') {
            include_once sprintf("model/%s.php", $object);
            $class = trim('services\v1\model\ ') . $object;
            return new $class;
        }
            include_once 'Validator.php';
        return new Validator();
    }

    /**
     * Select class
     *
     * This method is useful for get method class
     *
     * @param string $object name object class
     *
     * @return object
     */
    final public function selectClass(string $object): object
    {
        include_once sprintf("../model/%s.php", $object);
        $class = trim('services\v1\model\ ') . $object;
        return new $class;
    }

    /**
     * Validate identity
     *
     * This method return result validate identity user
     *
     * @param string $identity id user
     *
     * @return string | int | mixed
     */
    final public function validateIdentity(string $identity): string
    {
        $responses = new Responses();
        if (!isset($identity)) {
            return $responses->formatNotCorrect();
        }
        return '';
    }

    /**
     * Find token
     *
     * This method return data token, user id and state from user
     *
     * @param string $token user
     *
     * @return string | int | mixed
     * @throws JsonException
     */
    final public function findToken(string $token): array
    {
        $process = new Executor();
        $query = "SELECT 
        TokenId,
        UsuarioId,
        Estado 
        from usuarios_token WHERE 
        Token = '" . $token . "' AND 
        Estado = 'Activo'";
        $respond = $process->getData($query);
        if ($respond) {
            return $respond;
        }
        return [];
    }
}
