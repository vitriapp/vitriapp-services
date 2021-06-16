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
 *  * @license  Comercial
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
    public const USER_ID = 'UsuarioId';
    public const SECRET = 'Aa10Bb2D0z34MGTPp';

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
