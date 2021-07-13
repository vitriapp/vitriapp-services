<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/6/15 1:27:43
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\master;

use services\set\Constant;

/**
 * Class Responses
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Responses
{
    public array $response = [Constant::STATUS => 'OK', Constant::RESULT => []];

    /**
     * Method not allowed
     *
     * This method return server connection
     *
     * @return string | int | mixed
     */
    final public function methodNotAllowed(): array
    {
        $this->response[Constant::STATUS] = Constant::ERROR;
        $this->response[Constant::RESULT] = [
            Constant::ERROR_ID => 405,
            Constant::ERROR_MSG => Constant::METHOD_NOT_ALLOWED
        ];
        return $this->response;
    }

    /**
     * Incorrect data
     *
     * This method return message data incorrect
     *
     * @param string $valor the message data incorrect default
     *
     * @return mixed
     */
    final public function incorrectData(string $valor = Constant::INCORRECT): array
    {
        $this->response[Constant::STATUS] = Constant::ERROR;
        $this->response[Constant::RESULT] = [
            Constant::ERROR_ID => 200,
            Constant::ERROR_MSG => $valor
        ];
        return $this->response;
    }

    /**
     * Format not correct
     *
     * This method return message format incorrect
     *
     * @return string | int | mixed
     */
    final public function formatNotCorrect(): array
    {
        $this->response[Constant::STATUS] = Constant::ERROR;
        $this->response[Constant::RESULT] = [
            Constant::ERROR_ID => 400,
            Constant::ERROR_MSG => Constant::FORMAT_NOT_CORRECT
        ];
        return $this->response;
    }

    /**
     * Internal server error
     *
     * This method return message internal error server
     *
     * @param string $valor the message internal server error default
     *
     * @return mixed
     */
    final public function internalError(string $valor = Constant::SERVER_ERR): array
    {
        $this->response[Constant::STATUS] = Constant::ERROR;
        $this->response[Constant::RESULT] = [
            Constant::ERROR_ID => 500,
            Constant::ERROR_MSG => $valor
        ];
        return $this->response;
    }

    /**
     * Unauthorized
     *
     * This method return message unauthorized
     *
     * @param string $valor the message not authorized default
     *
     * @return mixed
     */
    final public function unauthorized(string $valor = Constant::AUTHORIZED): array
    {
        $this->response[Constant::STATUS] = Constant::ERROR;
        $this->response[Constant::RESULT] = [
            Constant::ERROR_ID => 401,
            Constant::ERROR_MSG => $valor
        ];
        return $this->response;
    }
}
