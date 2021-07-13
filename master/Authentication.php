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

use JsonException;
use services\master\connection\Executor;
use services\set\Constant;
use services\master\libs\Hash;

require_once __DIR__ . '/connection/Executor.php';
require_once __DIR__ . '/Responses.php';
require_once __DIR__ . '/../set/Constant.php';
require_once __DIR__ . '/libs/Hash.php';

/**
 * Class Authentication
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Authentication
{

    /**
     * Login
     *
     * This method is useful for login for get token.
     *
     * @param string $json data charged from database.
     *
     * @return mixed
     * @throws JsonException
     */
    final public function login(string $json): array
    {
        $process = new Executor();
        $response = new Responses();
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        $text_password = Constant::W_PASSWORD;
        if (isset($array[Constant::W_USER]) || isset($array[$text_password])) {
            $password = $process->encryptData($array[Constant::W_PASSWORD]);
            $array = $this->getUserData($array[Constant::W_USER]);
            return $this->validateLogin($password, $array);
        }
        return $response->formatNotCorrect();
    }

    /**
     * Validate login
     *
     * This method is useful for validate password for get new token.
     *
     * @param string $password the string to password
     * @param array $array data charged from database.
     *
     * @return mixed
     * @throws JsonException
     */
    private function validateLogin(string $password, array $array): array
    {
        $response = new Responses();
        if ($array) {
            return $this->validatePassword($password, $array);
        }
        return $response->incorrectData(Constant::USER_NO_EXIST);
    }

    /**
     * Validate password
     *
     * This method is useful for validate password for get new token.
     *
     * @param string $password the string to password
     * @param array $array data charged from database.
     *
     * @return mixed
     * @throws JsonException
     */
    private function validatePassword(string $password, array $array): array
    {
        $response = new Responses();
        $codes = Constant::USER_ID;
        $text_pass = Constant::W_PASS;
        if (crypt($password, $array[0][$text_pass]) === $array[0][$text_pass]) {
            return $this->getToken($array[0][Constant::W_STATE], $array[0][$codes]);
        }
        return $response->incorrectData(Constant::INVALID_PASSWORD);
    }

    /**
     * Get token
     *
     * This method is useful for get token through from state and userID
     *
     * @param string $state state user
     * @param string $userID ID user
     *
     * @return mixed
     * @throws JsonException
     */
    private function getToken(string $state, string $userID): array
    {
        $response = new Responses();
        if ($state === Constant::ACTIVE_A) {
            return $this->verifySaveToken($userID);
        }
        return $response->incorrectData(Constant::INACTIVE_USER);
    }

    /**
     * Verify save token
     *
     * This method is useful for get token through from userID
     *
     * @param string $userID ID user
     *
     * @return mixed
     * @throws JsonException
     */
    private function verifySaveToken(string $userID): array
    {
        $response = new Responses();
        $verify = $this->saveToken($userID);
        if ($verify) {
            $result = $response->response;
            $result[Constant::RESULT] = [
                Constant::TOKEN => $verify
            ];
            return $result;
        }
        return $response->internalError(Constant::INTERNAL_ERROR);
    }

    /**
     * Get user data
     *
     * This method is useful for get data access user
     *
     * @param string $email email user
     *
     * @return array|int|mixed
     * @throws JsonException
     */
    private function getUserData(string $email): array
    {
        $process = new Executor();
        $query = "CALL sp_data_access_user('$email')";
        $information = $process->getData($query);
        if (isset($information[0][Constant::USER_ID])) {
            return $information;
        }
        return 0;
    }

    /**
     * Save token
     *
     * This method is useful for save token generate
     *
     * @param string $userId ID user
     *
     * @return mixed
     * @throws JsonException
     */
    private function saveToken(string $userId): string
    {
        $process = new Executor();
        $hashes = new Hash();
        $token = bin2hex($hashes->crypt(Constant::SECRET));
        $generate = date('Y-m-d H:i');
        $state = Constant::ACTIVE;
        $query = "CALL sp_save_token('$userId','$token','$state','$generate')";
        if ($process->nonQuery($query)) {
            return $token;
        }
        return '0';
    }
}
