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

namespace services\master\connection;

use mysqli;
use services\set\Constant;

/**
 * Class Connection
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Connection extends mysqli
{
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    protected $connect;

    /**
     * Get Server
     *
     * This method return server connection
     *
     * @return string | int | mixed
     */
    final public function getServer(): string
    {
        return $this->server;
    }

    /**
     * Get User
     *
     * This method return user connection
     *
     * @return string | int | mixed
     */
    final public function getUser(): string
    {
        return $this->user;
    }

    /**
     * Get Password
     *
     * This method return password connection
     *
     * @return string | int | mixed
     */
    final public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Get Database
     *
     * This method return name database connection
     *
     * @return string | int | mixed
     */
    final public function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * Get Port
     *
     * This method return port database connection
     *
     * @return string | int | mixed
     */
    final public function getPort(): int
    {
        return $this->port;
    }

    /**
     * System
     *
     * This method return connection
     *
     * @return string | int | mixed
     */
    final public function systemAccess(): mysqli
    {
        $array_data = $this->connectionData();
        foreach ($array_data as $value) {
            $this->server = $value[Constant::SERVER];
            $this->user = $value[Constant::USER_DATABASE];
            $this->password = $value[Constant::PASSWORD];
            $this->database = $value[Constant::DATABASE];
            $this->port = $value[Constant::PORT_MYSQL];
        }

        $this->connect = new mysqli(
            $this->getServer(),
            $this->getUser(),
            $this->getPassword(),
            $this->getDatabase(),
            $this->getPort()
        );

        $this->connect->set_charset('utf8mb4');
        $this->connect->query('SET NAMES UTF8 COLLATE utf8mb4_spanish_ci');
        $this->connect->query('SET collation_connection = @@collation_database;');
        return $this->connect;
    }

    /**
     * Connection Data
     *
     * This method return data connection with json format
     *
     * @return string | int | mixed
     */
    private function connectionData(): array
    {
        $constant = new Constant();
        $folder = __DIR__;
        $environment = $constant->environment();
        $localhost = Constant::LOCALHOST;
        $develop =  Constant::CONFIG_DEV;
        $connection = $environment === $localhost ? $develop : Constant::CONFIG_PDN;
        $route = file_get_contents($folder . '/' . $connection);
        return json_decode($route, true);
    }
}
