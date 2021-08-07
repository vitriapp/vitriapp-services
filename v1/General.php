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
use services\set\Constant;
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
     * Action process
     *
     * This method is useful for execute various actions required
     *
     * @param string $method    name method dynamic
     * @param array  $arguments for search one or various results
     *
     * @return mixed
     * @throws JsonException
     */
    public function __call(string $method, array $arguments):array
    {
        $response = new Responses();
        $object = '';
        $array = json_decode($arguments[0], true, 512, JSON_THROW_ON_ERROR);
        if ($method === 'actionProcess') {
            $object = $arguments[2];
        }
        if (!isset($array['token'])) {
            return $response->unauthorized();
        }
        $token = $array['token'];
        $value = $this->findToken($token);
        return $this->executeProcess($value, $arguments[0], $arguments[1], $object);
    }

    /**
     * Execute process
     *
     * This method return result execute query for save patient
     *
     * @param array  $arrayToken data text field
     * @param string $json       data text field
     * @param string $option     for execute process
     * @param string $object     for required object
     *
     * @return string | int | mixed
     */
    private function executeProcess(
        array $arrayToken,
        string $json,
        string $option,
        string $object
    ):array {
        include_once sprintf("model/%s.php", $object);
        $response = new Responses();
        $objectClass = $this->selectClass($object);
        if ($arrayToken) {
            return $objectClass->{$option.'Validate'}($json);
        }
        return $response->unauthorized(Constant::INVALID_TOKEN);
    }

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
        return new self();
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
