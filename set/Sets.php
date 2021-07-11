<?php

declare(strict_types=1);

/**
 * *
 *  * PHP version 7.4
 *  *
 *  * @Date: 2021/6/14 0:19:41
 *  * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 *  * @category Developer
 *  * @package  Vitriapp
 *  * @license  Commercial
 *
 */

namespace services\set;

/**
 * Class Sets
 * @package services\set
 */
class Sets
{
    public const LOCALHOST = 'localhost';
    public const ENVIRONMENT_DEVELOP = 'config_dev';
    public const ENVIRONMENT_PRODUCTION = 'config_pdn';
    public const SERVER = 'server';
    public const USER_DATABASE = 'user';
    public const PASSWORD = 'password';
    public const DATABASE = 'database';
    public const PORT_MYSQL = 'port';
    public const ACTIVE = 'activo';
    public const ACTIVE_A = 'Activo';
    public const USER_ID = 'UsuarioId';
    public const SECRET = 'Aa10Bb2D0z34MGTPp';
    public const WORD_USER = 'usuario';
    public const WORD_PASSWORD = 'password';
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
    public const ERROR = 'error';
    public const METHOD_NOT_ALLOWED = 'Metodo no permitido';
    public const INCORRECT_DATA = 'Datos incorrectos';
    public const FORMAT_NOT_CORRECT = 'Datos enviados incompletos o con formato incorrecto';
    public const SERVER_INTERNAL_ERROR = 'Error interno del servidor';
    public const UNAUTHORIZED = 'No autorizado';
    public const PHP_INPUT = 'php://input';
    public const POST_DATA = 'POST';
    public const GET_DATA = 'GET';
    public const PUT_DATA = 'PUT';
    public const DELETE_DATA = 'DELETE';
    public const CONTENT_TYPE_JSON = 'Content-Type: application/json';

    final public static function environment(): string
    {
        $servername = $_SERVER['SERVER_NAME'];
        if ($servername === 'localhost') {
            return 'localhost';
        }
        return $servername;
    }

    final public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
