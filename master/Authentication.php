<?php

declare(strict_types=1);

/**
 * *
 *  * PHP version 7.4
 *  *
 *  * @Date: 2021/6/14 0:19:41
 *  * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 *  * @category Developer
 *  * @package  Vitriapp
 *  * @license  Commercial
 *
 */

namespace services\master;

use services\master\connection\Process;
use services\set\Sets;
use services\master\libs\Hash;

require_once __DIR__ . '/connection/Process.php';
require_once __DIR__ . '/Responses.php';
require_once __DIR__ . '/../set/Sets.php';
require_once __DIR__ . '/libs/Hash.php';

/**
 * Class auth
 */
class Authentication extends Process
{

    /**
     * _login
     *
     * This method is useful for login for get token.
     *
     * @param string $json data charged from database.
     *
     * @return mixed
     */
    final public function _login(string $json): array
    {
        $response = new Responses();
        $array = json_decode($json, true);
        if (isset($array[Sets::WORD_USER]) || isset($array[Sets::WORD_PASSWORD])) {
            $password = $this->encryptData($array[Sets::WORD_PASSWORD]);
            $array = $this->_getUserData($array[Sets::WORD_USER]);
            return $this->_validateLogin($password, $array);
        }
        return $response->formatNotCorrect();
    }

    /**
     * _ValidateLogin
     *
     * This method is useful for validate password for get new token.
     *
     * @param string $password the string to password
     * @param array $array data charged from database.
     *
     * @return array
     */
    private function _validateLogin(string $password, array $array): array
    {
        $response = new Responses();
        if ($array) {
            return $this->_validatePassword($password, $array);
        }
        return $response->incorrectData(Sets::USER_NO_EXIST);
    }

    /**
     * _validatePassword
     *
     * This method is useful for validate password for get new token.
     *
     * @param string $entryPassword the string to password
     * @param array $array data charged from database.
     *
     * @return array
     */
    private function _validatePassword(string $entryPassword, array $array): array
    {
        $response = new Responses();
        if (crypt($entryPassword, $array[0][Sets::WORD_PASSWORD_P]) === $array[0][Sets::WORD_PASSWORD_P]) {
            return $this->_getToken($array[0][Sets::WORD_STATE], $array[0][Sets::USER_ID]);
        }
        return $response->incorrectData(Sets::INVALID_PASSWORD);
    }

    /**
     * _getToken
     *
     * This method is useful for get token through from state and userID
     *
     * @param string $state state user
     * @param string $userID ID user
     *
     * @return mixed
     */
    private function _getToken(string $state, string $userID): array
    {
        $response = new Responses();
        if ($state === Sets::ACTIVE_A) {
            return $this->_verifySaveToken($userID);
        }
        return $response->incorrectData(Sets::INACTIVE_USER);
    }

    /**
     * _verifySaveToken
     *
     * This method is useful for get token through from userID
     *
     * @param string $userID ID user
     *
     * @return mixed
     */
    private function _verifySaveToken(string $userID): array
    {
        $response = new Responses();
        $verify = $this->_saveToken($userID);
        if ($verify) {
            $result = $response->response;
            $result[Sets::RESULT] = [
                Sets::TOKEN => $verify
            ];
            return $result;
        }
        return $response->internalError(Sets::INTERNAL_ERROR);
    }

    /**
     * _getUserData
     *
     * This method is useful for get data access user
     *
     * @param string $email email user
     *
     * @return array|int|mixed
     */
    private function _getUserData(string $email): array
    {
        $query = "CALL sp_data_access_user('$email')";
        $information = $this->getData($query);
        if (isset($information[0][Sets::USER_ID])) {
            return $information;
        }
        return 0;
    }

    /**
     * _saveToken
     *
     * This method is useful for save token generate
     *
     * @param string $userId ID user
     *
     * @return mixed
     */
    private function _saveToken(string $userId): string
    {
        $hashes = new Hash();
        $token = bin2hex($hashes->crypt(Sets::SECRET));
        $generate = date('Y-m-d H:i');
        $state = Sets::ACTIVE;
        $query = "CALL sp_save_token('$userId','$token','$state','$generate')";
        if ($this->nonQuery($query)) {
            return $token;
        }
        return '0';
    }
}
