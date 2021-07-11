<?php

declare(strict_types=1);

namespace services\master;

use services\set\Servicesset;

/**
 * Class Response
 */
class Responses
{
    public $response = [Servicesset::STATUS => 'OK', Servicesset::RESULT => []];

    final public function methodNotAllowed(): array
    {
        $this->response[Servicesset::STATUS] = Servicesset::ERROR;
        $this->response[Servicesset::RESULT] = [
            Servicesset::ERROR_ID => 405,
            Servicesset::ERROR_MSG => Servicesset::METHOD_NOT_ALLOWED
        ];
        return $this->response;
    }

    final public function incorrectData(string $valor = Servicesset::INCORRECT_DATA): array
    {
        $this->response[Servicesset::STATUS] = Servicesset::ERROR;
        $this->response[Servicesset::RESULT] = [
            Servicesset::ERROR_ID => 200,
            Servicesset::ERROR_MSG => $valor
        ];
        return $this->response;
    }

    final public function formatNotCorrect(): array
    {
        $this->response[Servicesset::STATUS] = Servicesset::ERROR;
        $this->response[Servicesset::RESULT] = [
            Servicesset::ERROR_ID => 400,
            Servicesset::ERROR_MSG => Servicesset::FORMAT_NOT_CORRECT
        ];
        return $this->response;
    }

    final public function internalError(string $valor = Servicesset::SERVER_INTERNAL_ERROR): array
    {
        $this->response[Servicesset::STATUS] = Servicesset::ERROR;
        $this->response[Servicesset::RESULT] = [
            Servicesset::ERROR_ID => 500,
            Servicesset::ERROR_MSG => $valor
        ];
        return $this->response;
    }

    final public function unauthorized(string $valor = Servicesset::UNAUTHORIZED): array
    {
        $this->response[Servicesset::STATUS] = Servicesset::ERROR;
        $this->response[Servicesset::RESULT] = [
            Servicesset::ERROR_ID => 401,
            Servicesset::ERROR_MSG => $valor
        ];
        return $this->response;
    }
}
