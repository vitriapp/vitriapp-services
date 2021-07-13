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
use services\master\libs\Util;
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

    private $table = 'pacientes';
    private $codeUser = '';
    private $identity = '';
    private $nameUser = '';
    private $address = '';
    private $postal = '';
    private $gender = '';
    private $telephone = '';
    private $birth = '0000-00-00';
    private $email = '';
    private $token = '';

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
    final public function postProcess(string $json):array
    {
        $response = new Responses();
        $array = json_decode($json, true);
        if (!isset($array['token'])) {
            return $response->unauthorized();
        }
        $this->token = $array['token'];
        $array_token =   $this->findToken();

        return $this->postProcessSave($array_token, $json);
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
    final public function putProcess(string $json):array
    {
        $responses = new Responses();
        $information = json_decode($json, true);
        if (!isset($information['token'])) {
            return $responses->unauthorized();
        }
        $this->token = $information['token'];
        $array_token =   $this->findToken();

        return $this->putProcessUpdate($array_token, $json);
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
    final public function deleteProcess(string $json):array
    {
        $responses = new Responses();
        $information = json_decode($json, true);
        if (!isset($information['token'])) {
            return $responses->unauthorized();
        }
        $this->token = $information['token'];
        $array_token =   $this->findToken();

        return $this->delProcessDelete($array_token, $json);
    }

    /**
     * Post process save
     *
     * This method return result execute query for save patient
     *
     * @param array  $array_token data text field
     * @param string $json        data text field
     *
     * @return string | int | mixed
     */
    private function postProcessSave(array $array_token, string $json):array
    {
        $response = new Responses();
        if ($array_token) {
            return $this->postValidate($json);
        }
        return $response->unauthorized(Constant::INVALID_TOKEN);
    }

    /**
     * Put process update
     *
     * This method return result execute query for update patient
     *
     * @param array  $array_token data text field
     * @param string $json        data text field
     *
     * @return string | int | mixed
     */
    private function putProcessUpdate(array $array_token, string $json):array
    {
        $responses = new Responses();
        if ($array_token) {
            return $this->putValidate($json);
        }

        return $responses->unauthorized(Constant::INVALID_TOKEN);
    }

    /**
     * Delete process
     *
     * This method return result execute query for delete patient
     *
     * @param array  $array_token data text field
     * @param string $json        data text field
     *
     * @return string | int | mixed
     */
    private function delProcessDelete(array $array_token, string $json):array
    {
        $responses = new Responses();
        if ($array_token) {
            return $this->deleteValidate($json);
        }
        return $responses->unauthorized(Constant::INVALID_TOKEN);
    }

    /**
     * Post validate
     *
     * This method is useful validate token for performed action in database
     *
     * @param string $json for show data from code patient
     *
     * @return mixed
     */
    final public function postValidate(string $json):array
    {
        $response = new Responses();
        $array = json_decode($json, true);

        $this->incorrectFormat($array['nombre'], $array['dni'], $array['correo']);

        $this->validateRequired(
            $array['nombre'],
            $array['dni'],
            $array['correo']
        );

        $this->validateAnother(
            $array['telefono'],
            $array['direccion'],
            $array['codigoPostal'],
            $array['genero'],
            $array['fechaNacimiento']
        );

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

    /**
     * Put validate
     *
     * This method is useful validate token for performed action in database
     *
     * @param string $json for show data from code patient
     *
     * @return mixed
     */
    final public function putValidate(string $json):array
    {
        $responses = new Responses();
        $information = json_decode($json, true);

        $this->validateIdentity($information['pacienteId']);

        $this->codeUser = $information['pacienteId'];

        $this->validateRequired(
            $information['nombre'],
            $information['dni'],
            $information['correo']
        );

        $this->validateAnother(
            $information['telefono'],
            $information['direccion'],
            $information['codigoPostal'],
            $information['genero'],
            $information['fechaNacimiento']
        );

        $respond = $this->updatePatient();
        if ($respond) {
            $answer = $responses->response;
            $answer['result'] = [
                'pacienteId' => $this->codeUser
            ];
            return $answer;
        }

        return $responses->internalError();
    }

    /**
     * Delete validate
     *
     * This method is useful validate token for performed action in database
     *
     * @param string $json for show data from code patient
     *
     * @return mixed
     */
    final public function deleteValidate(string $json):array
    {
        $responses = new Responses();
        $information = json_decode($json, true);

        $this->validateIdentity($information['pacienteId']);

        $this->codeUser = $information['pacienteId'];

        $respond = $this->deletePatient();
        if ($respond) {
            $answer = $responses->response;
            $answer['result'] = [
                'pacienteId' => $this->codeUser
            ];
            return $answer;
        }
        return $responses->internalError();
    }

    /**
     * Incorrect format
     *
     * This method return result execute query for save patient
     *
     * @param string $nameUser name user
     * @param string $identity id user
     * @param string $email    email user
     *
     * @return string | int | mixed
     */
    private function incorrectFormat(
        string $nameUser,
        string $identity,
        string $email
    ):string {
        $response = new Responses();
        if (!isset($nameUser, $identity, $email)) {
            return $response->formatNotCorrect();
        }
        return '';
    }

    /**
     * Validate field
     *
     * This method return result execute query for save patient
     *
     * @param string $name     name user
     * @param string $identity identity user
     * @param string $email    postal user
     *
     * @return string | int | mixed
     */
    private function validateRequired(
        string $name,
        string $identity,
        string $email
    ):bool {
        if (isset(
            $name,
            $identity,
            $email
        )) {
            $this->nameUser = $name;
            $this->identity = $identity;
            $this->email = $email;
            return true;
        }
        return false;
    }

    /**
     * Validate field
     *
     * This method return result execute query for save patient
     *
     * @param string $telephone telephone user
     * @param string $address   address user
     * @param string $postal    postal user
     * @param string $gender    gender user
     * @param string $birth     birth date user
     *
     * @return string | int | mixed
     */
    private function validateAnother(
        string $telephone,
        string $address,
        string $postal,
        string $gender,
        string $birth
    ):bool {
        if (isset(
            $telephone,
            $address,
            $postal,
            $gender,
            $birth
        )) {
            $this->telephone = $telephone;
            $this->address = $address;
            $this->postal = $postal;
            $this->gender = $gender;
            $this->birth = $birth;
            return true;
        }
        return false;
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
        $query = 'INSERT INTO ' . $this->table . "
        (DNI,Nombre,Direccion,CodigoPostal,Telefono,Genero,FechaNacimiento,Correo)
        values
        (
        '$this->identity', '$this->nameUser', '$this->address',
        '$this->postal', '$this->telephone', '$this->gender',
        '$this->birth', '$this->email')";
        $respond = $process->nonQueryId($query);
        if ($respond) {
            return $respond;
        }
            return 0;
    }

    /**
     * Validate identity
     *
     * This method return result validate identity user
     *
     * @param string $identity id user
     *
     * @return string | int | mixed
     */
    private function validateIdentity(string $identity):string
    {
        $responses = new Responses();
        if (!isset($identity)) {
            return $responses->formatNotCorrect();
        }
        return '';
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
        $query = 'UPDATE ' . $this->table . "
        SET 
        Nombre ='" . $this->nameUser . "',
        Direccion = '" . $this->address . "', 
        DNI = '" . $this->identity . "', 
        CodigoPostal = '" . $this->postal . "', 
        Telefono = '" . $this->telephone . "', 
        Genero = '" . $this->gender . "', 
        FechaNacimiento = '" . $this->birth . "', 
        Correo = '" . $this->email . "' 
        WHERE PacienteId = '" . $this->codeUser . "'";
        $respond = $process->nonQuery($query);
        if ($respond >= 1) {
            return $respond;
        }
            return 0;
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
        $query = 'DELETE FROM ' . $this->table . " 
        WHERE 
        PacienteId= '" . $this->codeUser . "'";
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
        $query = "SELECT 
        TokenId,
        UsuarioId,
        Estado 
        from usuarios_token WHERE 
        Token = '" . $this->token . "' AND 
        Estado = 'Activo'";
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
