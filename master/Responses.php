<?php

declare(strict_types=1);

namespace services\master;

use services\set\Sets;

/**
 * Class Response
 */
class Responses
{
    public $response = [Sets::STATUS => 'OK', Sets::RESULT => []];

    final public function methodNotAllowed(): array
    {
        $this->response[Sets::STATUS] = Sets::ERROR;
        $this->response[Sets::RESULT] = [
            Sets::ERROR_ID => 405,
            Sets::ERROR_MSG => Sets::METHOD_NOT_ALLOWED
        ];
        return $this->response;
    }

    final public function incorrectData(string $valor = Sets::INCORRECT_DATA): array
    {
        $this->response[Sets::STATUS] = Sets::ERROR;
        $this->response[Sets::RESULT] = [
            Sets::ERROR_ID => 200,
            Sets::ERROR_MSG => $valor
        ];
        return $this->response;
    }

    final public function formatNotCorrect(): array
    {
        $this->response[Sets::STATUS] = Sets::ERROR;
        $this->response[Sets::RESULT] = [
            Sets::ERROR_ID => 400,
            Sets::ERROR_MSG => Sets::FORMAT_NOT_CORRECT
        ];
        return $this->response;
    }

    final public function internalError(string $valor = Sets::SERVER_INTERNAL_ERROR): array
    {
        $this->response[Sets::STATUS] = Sets::ERROR;
        $this->response[Sets::RESULT] = [
            Sets::ERROR_ID => 500,
            Sets::ERROR_MSG => $valor
        ];
        return $this->response;
    }

    final public function unauthorized(string $valor = Sets::UNAUTHORIZED): array
    {
        $this->response[Sets::STATUS] = Sets::ERROR;
        $this->response[Sets::RESULT] = [
            Sets::ERROR_ID => 401,
            Sets::ERROR_MSG => $valor
        ];
        return $this->response;
    }
}
