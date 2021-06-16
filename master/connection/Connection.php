<?php

declare(strict_types=1);

namespace services\master\connection;

use mysqli;
use services\set\Sets;

/**
 * Class Connection
 */
class Connection extends mysqli
{
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    protected $connect;

    final public function getServer(): string
    {
        return $this->server;
    }

    final public function getUser(): string
    {
        return $this->user;
    }

    final public function getPassword(): string
    {
        return $this->password;
    }

    final public function getDatabase(): string
    {
        return $this->database;
    }

    final public function getPort(): int
    {
        return $this->port;
    }

    final public function system(): mysqli
    {
        $array_data = $this->connectionData();
        foreach ($array_data as $value) {
            $this->server = $value[Sets::SERVER];
            $this->user = $value[Sets::USER_DATABASE];
            $this->password = $value[Sets::PASSWORD];
            $this->database = $value[Sets::DATABASE];
            $this->port = $value[Sets::PORT_MYSQL];
        }

        $this->connect = new mysqli(
            $this->getServer(),
            $this->getUser(),
            $this->getPassword(),
            $this->getDatabase(),
            $this->getPort()
        );
        return $this->connect;
    }

    private function connectionData(): array
    {

        $folder = __DIR__;
        if (Sets::environment() === Sets::LOCALHOST) {
            $json_route = file_get_contents($folder . '/' . Sets::ENVIRONMENT_DEVELOP);
        } else {
            $json_route = file_get_contents($folder . '/' . Sets::ENVIRONMENT_PRODUCTION);
        }
        return json_decode($json_route, true);
    }

    final public function closeConnect(): bool
    {
        return $this->close();
    }
}
