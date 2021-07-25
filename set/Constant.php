<?php

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

namespace services\set;

/**
 * Class Constant
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Constant
{
    public const LOCALHOST = 'localhost';
    public const CONFIG_DEV = 'config_dev';
    public const CONFIG_PDN = 'config_pdn';
    public const SERVER = 'server';
    public const USER_DATABASE = 'user';
    public const PASSWORD = 'password';
    public const DATABASE = 'database';
    public const PORT_MYSQL = 'port';
    public const ACTIVE = 'activo';
    public const ACTIVE_A = 'Activo';
    public const USER_ID = 'UsuarioId';
    public const SECRET = 'Aa10Bb2D0z34MGTPp';
    public const W_USER = 'usuario';
    public const W_PASSWORD = 'password';
    public const W_PASS = 'Password';
    public const W_STATE = 'Estado';
    public const RESULT = 'result';
    public const TOKEN = 'token';
    public const USER_NO_EXIST = 'El usuario no existe';
    public const INVALID_PASSWORD = 'El password es invalido';
    public const INACTIVE_USER = 'El usuario esta inactivo';
    public const INTERNAL_ERROR = 'Error interno, No hemos podido guardar';
    public const ERROR_ID = 'error_id';
    public const ERROR_MSG = 'error_msg';
    public const STATUS = 'status';
    public const ERROR = 'Error';
    public const METHOD_NOT_ALLOWED = 'Metodo no permitido';
    public const INCORRECT = 'Datos incorrectos';
    public const FORMAT_NOT_CORRECT = 'Datos incompletos o con formato incorrecto';
    public const SERVER_ERR = 'Error interno del servidor';
    public const AUTHORIZED = 'No autorizado';
    public const PHP_INPUT = 'php://input';
    public const POST_DATA = 'POST';
    public const GET_DATA = 'GET';
    public const PUT_DATA = 'PUT';
    public const DELETE_DATA = 'DELETE';
    public const CONTENT_TYPE_JSON = 'Content-Type: application/json';
    public const INVALID_TOKEN = 'Token sent is invalid or has expired';

    /**
     * Environment
     *
     * This method return serve name local
     *
     * @return string | int | mixed
     */
    final public function environment(): string
    {
        $servername = filter_input(
            INPUT_SERVER,
            'SERVER_NAME',
            FILTER_SANITIZE_STRING
        );
        if ($servername === 'localhost') {
            return 'localhost';
        }
        return $servername;
    }

    /**
     * Method
     *
     * This method return name method request
     *
     * @return string | int | mixed
     */
    final public function method(): string
    {
        $value = filter_input(
            INPUT_SERVER,
            'REQUEST_METHOD',
            FILTER_SANITIZE_STRING
        );
        if (empty($value)) {
            return '';
        }
        return $value;
    }
}
