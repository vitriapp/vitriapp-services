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
 *  * @license  Comercial
 *
 */

namespace services\master;

use http\Exception\InvalidArgumentException;
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

    final public function login($json)
    {
        $hashes = new Hash();
        $_respustas = new Responses();
        $datos = json_decode($json, true);
        if (!isset($datos['usuario']) || !isset($datos["password"])) {
            return $_respustas->error_400();
        } else {
            $usuario = $datos['usuario'];
            //$password = bin2hex(sha1(md5(sha1($datos['password']))));
            $password = $this->encryptData($datos['password']);
            $datos = $this->getUserData($usuario);
            if ($datos) {
                //verificar si la contraseña es igual
                //if ($password === $datos[0]['Password']) {
                if (crypt($password, $datos[0]['Password']) === $datos[0]['Password']) {
                    if ($datos[0]['Estado'] == "Activo") {
                        //crear el token
                        $verificar = $this->saveToken($datos[0]['UsuarioId']);
                        if ($verificar) {
                            // si se guardo
                            $result = $_respustas->response;
                            $result["result"] = array(
                                "token" => $verificar
                            );
                            return $result;
                        } else {
                            //error al guardar
                            return $_respustas->error_500("Error interno, No hemos podido guardar");
                        }
                    } else {
                        //el usuario esta inactivo
                        return $_respustas->error_200("El usuario esta inactivo");
                    }
                } else {
                    //la contraseña no es igual
                    return $_respustas->error_200("El password es invalido");
                }
            } else {
                //no existe el usuario
                return $_respustas->error_200("El usuaro $usuario  no existe ");
            }
        }
    }


    /**
     * @param $email
     * @return array|int|mixed
     */
    private function getUserData(string $email): array
    {
        $query = "CALL sp_data_access_user('$email' COLLATE utf8_unicode_ci)";
        $information = $this->getData($query);
        if (isset($information[0][Sets::USER_ID])) {
            return $information;
        }
        return 0;
    }

    /**
     * @param $userId
     * @return mixed
     */
    private function saveToken(string $userId): string
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
