<?php

declare(strict_types=1);

namespace services\master;

/**
 * Class Response
 */
class Responses
{
    public $response = ['status' => "ok", "result" => []];

    /**
     * @return array
     */
    final public function error405(): array
    {
        $this->response['status'] = "error";
        $this->response['result'] = [
            "error_id" => "405",
            "error_msg" => "Metodo no permitido"
        ];
        return $this->response;
    }

    /**
     * @param string $valor
     * @return mixed
     */
    final public function error_200(string $valor = 'Datos incorrectos'): array
    {
        $this->response['status'] = 'error';
        $this->response['result'] = [
            'error_id' => '200',
            'error_msg' => $valor
        ];
        return $this->response;
    }


    public function error_400()
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => "Datos enviados incompletos o con formato incorrecto"
        );
        return $this->response;
    }


    public function error_500($valor = "Error interno del servidor")
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "500",
            "error_msg" => $valor
        );
        return $this->response;
    }


    public function error_401($valor = "No autorizado")
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "401",
            "error_msg" => $valor
        );
        return $this->response;
    }
}
