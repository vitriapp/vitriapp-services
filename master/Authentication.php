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
 */

namespace services\master;

use services\master\connection\Process;
use services\set\Servicesset;
use services\master\libs\Hash;

require_once __DIR__ . '/connection/Process.php';
require_once __DIR__ . '/Responses.php';
require_once __DIR__ . '/../set/Servicesset.php';
require_once __DIR__ . '/libs/Hash.php';

/**
 * Class Authentication
 *
 * @author  Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license Commercial PHP License 1.0
 * @link    https://www.vitriapp.com PHP License 1.0
 */
class Authentication
{

    /**
     * login
     *
     * This method is useful for login for get token.
     *
     * @param string $json data charged from database.
     *
     * @return mixed
     */
    final public function login(string $json): array
    {
        $process = new Process();
        $response = new Responses();
        $array = json_decode($json, true);
        if (isset($array[Servicesset::WORD_USER]) || isset($array[Servicesset::WORD_PASSWORD])) {
            $password = $process->encryptData($array[Servicesset::WORD_PASSWORD]);
            $array = $this->getUserData($array[Servicesset::WORD_USER]);
            return $this->validateLogin($password, $array);
        }
        return $response->formatNotCorrect();
    }

    /**
     * validateLogin
     *
     * This method is useful for validate password for get new token.
     *
     * @param string $password the string to password
     * @param array  $array    data charged from database.
     *
     * @return mixed
     */
    private function validateLogin(string $password, array $array): array
    {
        $response = new Responses();
        if ($array) {
            return $this->validatePassword($password, $array);
        }
        return $response->incorrectData(Servicesset::USER_NO_EXIST);
    }

    /**
     * validatePassword
     *
     * This method is useful for validate password for get new token.
     *
     * @param string $password the string to password
     * @param array  $array    data charged from database.
     *
     * @return mixed
     */
    private function validatePassword(string $password, array $array): array
    {
        $response = new Responses();
        $codes = Servicesset::USER_ID;
        if (crypt($password, $array[0][Servicesset::W_PASS]) === $array[0][Servicesset::W_PASS]) {
            return $this->getToken($array[0][Servicesset::W_STATE], $array[0][$codes]);
        }
        return $response->incorrectData(Servicesset::INVALID_PASSWORD);
    }

    /**
     * getToken
     *
     * This method is useful for get token through from state and userID
     *
     * @param string $state  state user
     * @param string $userID ID user
     *
     * @return mixed
     */
    private function getToken(string $state, string $userID): array
    {
        $response = new Responses();
        if ($state === Servicesset::ACTIVE_A) {
            return $this->verifySaveToken($userID);
        }
        return $response->incorrectData(Servicesset::INACTIVE_USER);
    }

    /**
     * verifySaveToken
     *
     * This method is useful for get token through from userID
     *
     * @param string $userID ID user
     *
     * @return mixed
     */
    private function verifySaveToken(string $userID): array
    {
        $response = new Responses();
        $verify = $this->saveToken($userID);
        if ($verify) {
            $result = $response->response;
            $result[Servicesset::RESULT] = [
                Servicesset::TOKEN => $verify
            ];
            return $result;
        }
        return $response->internalError(Servicesset::INTERNAL_ERROR);
    }

    /**
     * getUserData
     *
     * This method is useful for get data access user
     *
     * @param string $email email user
     *
     * @return array|int|mixed
     */
    private function getUserData(string $email): array
    {
        $process = new Process();
        $query = "CALL sp_data_access_user('$email')";
        $information = $process->getData($query);
        if (isset($information[0][Servicesset::USER_ID])) {
            return $information;
        }
        return 0;
    }

    /**
     * saveToken
     *
     * This method is useful for save token generate
     *
     * @param string $userId ID user
     *
     * @return mixed
     */
    private function saveToken(string $userId): string
    {
        $process = new Process();
        $hashes = new Hash();
        $token = bin2hex($hashes->crypt(Servicesset::SECRET));
        $generate = date('Y-m-d H:i');
        $state = Servicesset::ACTIVE;
        $query = "CALL sp_save_token('$userId','$token','$state','$generate')";
        if ($process->nonQuery($query)) {
            return $token;
        }
        return '0';
    }
}
