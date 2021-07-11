<?php

declare(strict_types=1);

namespace services\master;

use services\set\Constant;

/**
 * Class Response
 */
class Responses
{
    public $response = [Constant::STATUS => 'OK', Constant::RESULT => []];

    final public function methodNotAllowed(): array
    {
        $this->response[Constant::STATUS] = Constant::ERROR;
        $this->response[Constant::RESULT] = [
            Constant::ERROR_ID => 405,
            Constant::ERROR_MSG => Constant::METHOD_NOT_ALLOWED
        ];
        return $this->response;
    }

    final public function incorrectData(string $valor = Constant::INCORRECT_DATA): array
    {
        $this->response[Constant::STATUS] = Constant::ERROR;
        $this->response[Constant::RESULT] = [
            Constant::ERROR_ID => 200,
            Constant::ERROR_MSG => $valor
        ];
        return $this->response;
    }

    final public function formatNotCorrect(): array
    {
        $this->response[Constant::STATUS] = Constant::ERROR;
        $this->response[Constant::RESULT] = [
            Constant::ERROR_ID => 400,
            Constant::ERROR_MSG => Constant::FORMAT_NOT_CORRECT
        ];
        return $this->response;
    }

    final public function internalError(string $valor = Constant::SERVER_INTERNAL_ERROR): array
    {
        $this->response[Constant::STATUS] = Constant::ERROR;
        $this->response[Constant::RESULT] = [
            Constant::ERROR_ID => 500,
            Constant::ERROR_MSG => $valor
        ];
        return $this->response;
    }

    final public function unauthorized(string $valor = Constant::UNAUTHORIZED): array
    {
        $this->response[Constant::STATUS] = Constant::ERROR;
        $this->response[Constant::RESULT] = [
            Constant::ERROR_ID => 401,
            Constant::ERROR_MSG => $valor
        ];
        return $this->response;
    }
}
