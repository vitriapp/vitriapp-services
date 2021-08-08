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
use services\master\libs\Util;
use services\master\Responses;
use services\set\Constant;
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
    public Executor  $process;
    public Responses $response;
    public Constant  $constant;
    public General   $general;

    private string $codeUser  = '';
    private string $identity  = '';
    private string $nameUser  = '';
    private string $address   = '';
    private string $postal    = '';
    private string $gender    = '';
    private string $telephone = '';
    private string $birth     = '0000-00-00';
    private string $email     = '';

    private bool   $success;
    private string $contentType;
    private string $responds;
    private string $status;
    private string $dateRequest;
    private string $clientIp;

    public function __construct()
    {
        $util = new Util();
        $this->process  = new Executor();
        $this->response = new Responses();
        $this->constant = new Constant();
        $this->general = new General();

        $this->success     = true;
        $this->contentType = 'application/json; charset=UTF-8';
        $this->responds    = 'HTTP/1.1 200 OK';
        $this->status      = '200';
        $this->dateRequest = Date('Y-m-d H:i:s');
        $this->clientIp    = $util->getIpClient();
    }

    /**
     *
     * Get ip client
     *
     * This method get ip client
     *
     * @return string
     */
    final public function getClientIp(): string
    {
        return $this->clientIp;
    }

    /**
     * List
     *
     * This method is useful for get list register from database
     *
     * @param int $page for show quantity registers
     *
     * @return mixed | int
     * @throws JsonException
     */
    final public function list(int $page = 1): array
    {
        $initial = 0;
        $quantity = 200;
        if ($page > 1) {
            $initial = ($quantity * ($page - 1)) + 1;
            $quantity *= $page;
        }
        return $this->process->getData("CALL get_all_patients($initial,$quantity)");
    }

    /**
     * Get
     *
     * This method is useful for get one register from code
     *
     * @param int $codes for show data from code patient
     *
     * @return mixed | int
     * @throws JsonException
     */
    final public function get(int $codes): array
    {
        return $this->process->getData("CALL get_patient($codes)");
    }

    /**
     * Get data register
     *
     * This method is useful for get data for use to store procedure
     *
     * @return array
     */
    final public function getData(): array
    {
        $id = 0;
        if ($this->codeUser !== '') {
            $id = $this->codeUser;
        }
        return array(
            "'$id'",
            "'$this->identity'",
            "'$this->nameUser'",
            "'$this->address'",
            "'$this->postal'",
            "'$this->telephone'",
            "'$this->gender'",
            "'$this->birth'",
            "'$this->email'");
    }

    /**
     * Get information response
     *
     * This method is useful for get data for use to store procedure
     *
     * @param string $process message process class
     * @param string $message message successfully action
     *
     * @return array
     */
    final public function getInformationResponse(string $process, string $message): array
    {
        return [
            'Success'          => $this->success,
            'Content-Type'     => $this->contentType,
            'Respond'          => $this->responds,
            'Status'           => $this->status,
            'Date request'     => $this->dateRequest,
            'Client ip'        => $this->getClientIp(),
            'Executed process' => $process,
            'Message'          => $message
        ];
    }

    /**
     * Process BD actions
     *
     * This method return result execute query insert in database
     *
     * @param string $action execute process in database
     *
     * @return string | int | mixed
     * @throws JsonException
     */
    final public function processBdActions(string $action): int
    {
        if ($action === 'insert') {
            $query = "CALL sp_new_patient(". implode(',', $this->getData()) .")";
        } elseif ($action === 'update') {
            $query = "CALL sp_update_patient(". implode(',', $this->getData()) .")";
        } else {
            $query = "CALL sp_delete_patient('$this->codeUser')";
        }
        $respond = $this->process->nonQuery($query);
        if ($respond) {
            return $respond;
        }
        return 0;
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
    final public function postValidate(string $json): array
    {
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        $this->incorrectFormat($array['nombre'], $array['dni'], $array['correo']);

        $this->validateRequired(
            $array['nombre'],
            $array['dni'],
            $array['correo'],
            $array['telefono'],
            $array['direccion'],
            $array['codigoPostal'],
            $array['genero'],
            $array['fechaNacimiento']
        );

        $respond = $this->processBdActions('insert');

        if ($respond) {
            $answer = $this->response->response;
            $answer['result'] = $this->getInformationResponse(
                'Insert patient',
                'Register inserted successfully'
            );
            return $answer;
        }
        return $this->response->internalError();
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
    final public function putValidate(string $json): array
    {
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        $this->general->validateIdentity($array['id']);
        $this->codeUser = $array['id'];

        $this->validateRequired(
            $array['nombre'],
            $array['dni'],
            $array['correo'],
            $array['telefono'],
            $array['direccion'],
            $array['codigoPostal'],
            $array['genero'],
            $array['fechaNacimiento']
        );

        $respond = $this->processBdActions('update');
        if ($respond) {
            $answer = $this->response->response;
            $answer['result'] = $this->getInformationResponse(
                'Update patient',
                'Register updated successfully'
            );
            return $answer;
        }

        return $this->response->internalError();
    }

    /**
     * Delete validate
     *
     * This method is useful validate token for performed action in database
     *
     * @param string $json for show data from code
     *
     * @return mixed
     * @throws JsonException
     */
    final public function deleteValidate(string $json): array
    {
        $information = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        $this->general->validateIdentity($information['id']);
        $this->codeUser = $information['id'];

        $respond = $this->processBdActions('delete');
        if ($respond) {
            $answer = $this->response->response;
            $answer['result'] = $this->getInformationResponse(
                'Delete patient',
                'Register deleted successfully'
            );
            return $answer;
        }
        return $this->response->internalError();
    }

    /**
     * Validate field
     *
     * This method return result execute query for save patient
     *
     * @param string $name name user
     * @param string $identity identity user
     * @param string $email postal user
     * @param string $telephone telephone user
     * @param string $address address user
     * @param string $postal postal user
     * @param string $gender gender user
     * @param string $birth birth date user
     *
     * @return string | int | mixed
     */
    final public function validateRequired(
        string $name,
        string $identity,
        string $email,
        string $telephone,
        string $address,
        string $postal,
        string $gender,
        string $birth
    ): bool {
        if (isset(
            $name,
            $identity,
            $email,
            $telephone,
            $address,
            $postal,
            $gender,
            $birth
        )
        ) {
            $this->nameUser  = $name;
            $this->identity  = $identity;
            $this->email     = $email;
            $this->telephone = $telephone;
            $this->address   = $address;
            $this->postal    = $postal;
            $this->gender    = $gender;
            $this->birth     = $birth;
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
     * @param string $email email user
     *
     * @return string | int | mixed
     */
    final public function incorrectFormat(
        string $nameUser,
        string $identity,
        string $email
    ): string {
        if (!isset(
            $nameUser,
            $identity,
            $email
        )
        ) {
            return $this->response->formatNotCorrect();
        }
        return '';
    }
}
