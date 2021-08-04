<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/7/29 9:3:4
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\v1\model;

use JsonException;
use services\master\connection\Executor;
use services\master\Responses;
use services\v1\General;

require_once '../../master/connection/Executor.php';
require_once '../../master/Responses.php';
require_once '../General.php';
require_once 'IModel.php';

/**
 * Class Patients
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Patients implements IModel
{

    private string $tablePatients = 'pacientes';
    private string $codeUser = '';
    private string $identity = '';
    private string $nameUser = '';
    private string $address = '';
    private string $postal = '';
    private string $gender = '';
    private string $telephone = '';
    private string $birth = '0000-00-00';
    private string $email = '';

    /**
     * List patients
     *
     * This method is useful for get list patients from database
     *
     * @param int $page for show quantity registers
     *
     * @return mixed | int
     * @throws JsonException
     */
    final public function list(int $page = 1):array
    {
        $process = new Executor();
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
     * @throws JsonException
     */
    final public function get(int $codes):array
    {
        $process = new Executor();
        $query = "CALL get_patient($codes)";
        return $process->getData($query);
    }

    /**
     * Post validate
     *
     * This method is useful validate token for performed action in database
     *
     * @param string $json for show data from code patient
     *
     * @return mixed
     * @throws JsonException
     */
    final public function postValidate(string $json):array
    {
        $response = new Responses();
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $this->incorrectFormat(
            $array['nombre'],
            $array['dni'],
            $array['correo']
        );

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

        $respond = $this->insert();

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
     * @throws JsonException
     */
    final public function putValidate(string $json):array
    {
        $responses = new Responses();
        $general = new General();
        $information = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $general->validateIdentity($information['id']);

        $this->codeUser = $information['id'];

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

        $respond = $this->update();
        if ($respond) {
            $answer = $responses->response;
            $answer['result'] = [
                'id' => $this->codeUser
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
     * @throws JsonException
     */
    final public function deleteValidate(string $json):array
    {
        $responses = new Responses();
        $general = new General();
        $information = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $general->validateIdentity($information['id']);
        $this->codeUser = $information['id'];

        $respond = $this->delete();
        if ($respond) {
            $answer = $responses->response;
            $answer['result'] = [
                'id' => $this->codeUser
            ];
            return $answer;
        }
        return $responses->internalError();
    }

    /**
     * Insert patient
     *
     * This method return result execute query insert in database
     *
     * @return string | int | mixed
     * @throws JsonException
     */
    final public function insert():int
    {
        $process = new Executor();
        $query = 'INSERT INTO ' . $this->tablePatients . "
        (
        DNI, Nombre, Direccion,
        CodigoPostal, Telefono, Genero,
        FechaNacimiento, Correo
        )
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
     * Update patient
     *
     * This method return result execute query update patient
     *
     * @return string | int | mixed
     * @throws JsonException
     */
    final public function update():int
    {
        $process = new Executor();
        $query = 'UPDATE ' . $this->tablePatients . "
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
     * @throws JsonException
     */
    final public function delete():int
    {
        $process = new Executor();
        $query = 'DELETE FROM ' . $this->tablePatients . " 
        WHERE 
        PacienteId= '" . $this->codeUser . "'";
        $respond = $process->nonQuery($query);
        if ($respond >= 1) {
            return $respond;
        }
        return 0;
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
    final public function validateRequired(
        string $name,
        string $identity,
        string $email
    ):bool {
        if (isset($name, $identity, $email)) {
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
    final public function validateAnother(
        string $telephone,
        string $address,
        string $postal,
        string $gender,
        string $birth
    ):bool {
        if (isset($telephone, $address, $postal, $gender, $birth)) {
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
    final public function incorrectFormat(
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
}
