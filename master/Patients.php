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

namespace services\master;

use services\master\connection\Process;
use services\set\Constant;

require_once __DIR__ . '/connection/Process.php';
require_once __DIR__ . '/Responses.php';

/**
 * Class Patients
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Patients
{

    private $table = "pacientes";
    private $pacienteid = "";
    private $dni = "";
    private $nombre = "";
    private $direccion = "";
    private $codigoPostal = "";
    private $genero = "";
    private $telefono = "";
    private $fechaNacimiento = "0000-00-00";
    private $correo = "";
    private $token = "";

    /**
     * List patients
     *
     * This method is useful for get list patients from database
     *
     * @param int $page for show quantity registers
     *
     * @return mixed | int
     */
    final public function listPatients(int $page = 1):array
    {
        $process = new Process();
        $initial  = 0 ;
        $quantity = 100;
        if ($page > 1) {
            $initial = ($quantity * ($page - 1)) +1 ;
            $quantity *= $page;
        }
        $query = "CALL get_all_patients($initial, $quantity)";
        $registers = $process->getData($query);
        return ($registers);
    }

    /**
     * Get patient
     *
     * This method is useful for get one patient from code
     *
     * @param int $codes for show data from code patient
     *
     * @return mixed | int
     */
    final public function getPatient(int $codes):array
    {
        $process = new Process();
        $query = "CALL get_patient($codes)";
        return $process->getData($query);
    }

    /**
     * Send data process post
     *
     * This method is useful for get one patient from code
     *
     * @param string $json for show data from code patient
     *
     * @return mixed
     */
    public function sendDataProcess($json):array
    {
        $response = new Responses();
        $array = json_decode($json, true);

        if (!isset($array['token'])) {
            return $response->unauthorized();
        }

        $this->token = $array['token'];
        $array_token =   $this->findToken();
        if ($array_token) {
            if (!isset($array['nombre']) || !isset($array['dni']) || !isset($array['correo'])) {
                return $response->formatNotCorrect();
            }

            $this->nombre = $array['nombre'];
            $this->dni = $array['dni'];
            $this->correo = $array['correo'];
            if (isset($array['telefono'])) {
                $this->telefono = $array['telefono'];
            }
            if (isset($array['direccion'])) {
                $this->direccion = $array['direccion'];
            }
            if (isset($array['codigoPostal'])) {
                $this->codigoPostal = $array['codigoPostal'];
            }
            if (isset($array['genero'])) {
                $this->genero = $array['genero'];
            }
            if (isset($array['fechaNacimiento'])) {
                $this->fechaNacimiento = $array['fechaNacimiento'];
            }
            $respond = $this->insertPatient();
            if ($respond) {
                $answer = $response->response;
                $answer['result'] = [
                    'pacienteId' => $respond
                ];
                return $answer;
            }
            return $response->internalError();
        }

        return $response->unauthorized(Constant::INVALID_TOKEN);
    }

    /**
     * Insert patient
     *
     * This method return result execute query insert in database
     *
     * @return string | int | mixed
     */
    private function insertPatient():int
    {
        $process = new Process();
        $query = "INSERT INTO " . $this->table . " (DNI,Nombre,Direccion,CodigoPostal,Telefono,Genero,FechaNacimiento,Correo)
        values
        ('" . $this->dni . "','" . $this->nombre . "','" . $this->direccion ."','" . $this->codigoPostal . "','"  . $this->telefono . "','" . $this->genero . "','" . $this->fechaNacimiento . "','" . $this->correo . "')";
        $respond = $process->nonQueryId($query);
        if ($respond) {
            return $respond;
        }
            return 0;
    }

    /**
     * Send data process put
     *
     * This method is useful for get one patient from code
     *
     * @param string $json for show data from code patient
     *
     * @return mixed
     */
    public function put($json)
    {
        $responses = new Responses();
        $information = json_decode($json, true);

        if (!isset($information['token'])) {
            return $responses->unauthorized();
        }

        $this->token = $information['token'];
        $array_token =   $this->findToken();
        if ($array_token) {
            if (!isset($information['pacienteId'])) {
                return $responses->formatNotCorrect();
            }

            $this->pacienteid = $information['pacienteId'];
            if (isset($information['nombre'])) {
                $this->nombre = $information['nombre'];
            }
            if (isset($information['dni'])) {
                $this->dni = $information['dni'];
            }
            if (isset($information['correo'])) {
                $this->correo = $information['correo'];
            }
            if (isset($information['telefono'])) {
                $this->telefono = $information['telefono'];
            }
            if (isset($information['direccion'])) {
                $this->direccion = $information['direccion'];
            }
            if (isset($information['codigoPostal'])) {
                $this->codigoPostal = $information['codigoPostal'];
            }
            if (isset($information['genero'])) {
                $this->genero = $information['genero'];
            }
            if (isset($information['fechaNacimiento'])) {
                $this->fechaNacimiento = $information['fechaNacimiento'];
            }

            $respond = $this->updatePatient();
            if ($respond) {
                $answer = $responses->response;
                $answer['result'] = [
                    'pacienteId' => $this->pacienteid
                ];
                return $answer;
            }

            return $responses->internalError();
        }

        return $responses->unauthorized(Constant::INVALID_TOKEN);
    }

    /**
     * Update patient
     *
     * This method return result execute query update patient
     *
     * @return string | int | mixed
     */
    private function updatePatient():int
    {
        $process = new Process();
        $query = "UPDATE " . $this->table . " SET Nombre ='" . $this->nombre . "',Direccion = '" . $this->direccion . "', DNI = '" . $this->dni . "', CodigoPostal = '" .
            $this->codigoPostal . "', Telefono = '" . $this->telefono . "', Genero = '" . $this->genero . "', FechaNacimiento = '" . $this->fechaNacimiento . "', Correo = '" . $this->correo .
            "' WHERE PacienteId = '" . $this->pacienteid . "'";
        $respond = $process->nonQuery($query);
        if ($respond >= 1) {
            return $respond;
        }
            return 0;
    }

    /**
     * Delete patients with id from database
     *
     * This method is useful for delete one patient from code
     *
     * @param string $json for show data from code patient
     *
     * @return mixed
     */
    public function delete($json):array
    {
        $responses = new Responses();
        $information = json_decode($json, true);

        if (!isset($information['token'])) {
            return $responses->unauthorized();
        }
        $this->token = $information['token'];
        $array =   $this->findToken();
        if ($array) {
            if (!isset($information['pacienteId'])) {
                return $responses->formatNotCorrect();
            }
            $this->pacienteid = $information['pacienteId'];
            $respond = $this->deletePatient();
            if ($respond) {
                $answer = $responses->response;
                $answer['result'] = [
                    'pacienteId' => $this->pacienteid
                ];
                return $answer;
            }
            return $responses->internalError();
        }
        return $responses->unauthorized(Constant::INVALID_TOKEN);
    }

    /**
     * Delete patient
     *
     * This method return result execute query delete patient
     *
     * @return string | int | mixed
     */
    private function deletePatient():int
    {
        $process = new Process();
        $query = "DELETE FROM " . $this->table . " WHERE PacienteId= '" . $this->pacienteid . "'";
        $respond = $process->nonQuery($query);
        if ($respond >= 1) {
            return $respond;
        }
        return 0;
    }

    /**
     * Find token
     *
     * This method return data token, user id and state from user
     *
     * @return string | int | mixed
     */
    private function findToken():array
    {
        $process = new Process();
        $query = "SELECT TokenId,UsuarioId,Estado from usuarios_token WHERE Token = '" . $this->token . "' AND Estado = 'Activo'";
        $respond = $process->getData($query);
        if ($respond) {
            return $respond;
        }
        return 0;
    }

    /**
     * Update token
     *
     * This method is useful for update token user
     *
     * @param string $token for show quantity registers
     *
     * @return mixed | int
     */
    private function updateToken(string $token):int
    {
        $process = new Process();
        $datetime = date('Y-m-d H:i');
        $query = "UPDATE usuarios_token SET Fecha = '$datetime' WHERE TokenId = '$token' ";
        $respond = $process->nonQuery($query);
        if ($respond >= 1) {
            return $respond;
        }
        return 0;
    }
}