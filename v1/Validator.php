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
use services\master\Responses;
use services\set\Constant;

require_once 'General.php';

/**
 * Class Patients validator
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Validator
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
        $general = new General();
        $object = '';
        $array = json_decode($arguments[0], true, 512, JSON_THROW_ON_ERROR);
        if ($method === 'actionProcess') {
            $object = $arguments[2];
        }
        if (!isset($array['token'])) {
            return $response->unauthorized();
        }
        $token = $array['token'];
        $value =   $general->findToken($token);
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
        $general = new General();
        $objectClass = $general->selectClass($object);
        if ($arrayToken) {
            return $objectClass->{$option.'Validate'}($json);
        }
        return $response->unauthorized(Constant::INVALID_TOKEN);
    }
}
