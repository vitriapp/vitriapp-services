<?php

declare(strict_types=1);

namespace services\master;

use services\master\connection\Process;

require_once __DIR__ . '/connection/Process.php';
require_once __DIR__ . '/Responses.php';

/**
 * Class Patients
 */
class Patients extends Process
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

    public function listaPacientes($pagina = 1)
    {
        $inicio  = 0 ;
        $cantidad = 100;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) +1 ;
            $cantidad = $cantidad * $pagina;
        }
        $query = "CALL get_all_patients($inicio, $cantidad)";
        $datos = parent::getData($query);
        return ($datos);
    }

    public function obtenerPaciente($id)
    {
        $query = "CALL get_patient($id)";
        return parent::getData($query);
    }

    public function post($json)
    {
        $_respuestas = new Responses;
        $datos = json_decode($json, true);

        if (!isset($datos['token'])) {
                return $_respuestas->unauthorized();
        } else {
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if ($arrayToken) {
                if (!isset($datos['nombre']) || !isset($datos['dni']) || !isset($datos['correo'])) {
                    return $_respuestas->formatNotCorrect();
                } else {
                    $this->nombre = $datos['nombre'];
                    $this->dni = $datos['dni'];
                    $this->correo = $datos['correo'];
                    if (isset($datos['telefono'])) {
                        $this->telefono = $datos['telefono'];
                    }
                    if (isset($datos['direccion'])) {
                        $this->direccion = $datos['direccion'];
                    }
                    if (isset($datos['codigoPostal'])) {
                        $this->codigoPostal = $datos['codigoPostal'];
                    }
                    if (isset($datos['genero'])) {
                        $this->genero = $datos['genero'];
                    }
                    if (isset($datos['fechaNacimiento'])) {
                        $this->fechaNacimiento = $datos['fechaNacimiento'];
                    }
                    $resp = $this->insertarPaciente();
                    if ($resp) {
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "pacienteId" => $resp
                        );
                        return $respuesta;
                    } else {
                        return $_respuestas->internalError();
                    }
                }
            } else {
                return $_respuestas->unauthorized("El Token que envio es invalido o ha caducado");
            }
        }
    }


    private function insertarPaciente()
    {
        $query = "INSERT INTO " . $this->table . " (DNI,Nombre,Direccion,CodigoPostal,Telefono,Genero,FechaNacimiento,Correo)
        values
        ('" . $this->dni . "','" . $this->nombre . "','" . $this->direccion ."','" . $this->codigoPostal . "','"  . $this->telefono . "','" . $this->genero . "','" . $this->fechaNacimiento . "','" . $this->correo . "')";
        $resp = parent::nonQueryId($query);
        if ($resp) {
             return $resp;
        } else {
            return 0;
        }
    }
    
    public function put($json)
    {
        $_respuestas = new Responses;
        $datos = json_decode($json, true);

        if (!isset($datos['token'])) {
            return $_respuestas->unauthorized();
        } else {
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if ($arrayToken) {
                if (!isset($datos['pacienteId'])) {
                    return $_respuestas->formatNotCorrect();
                } else {
                    $this->pacienteid = $datos['pacienteId'];
                    if (isset($datos['nombre'])) {
                        $this->nombre = $datos['nombre'];
                    }
                    if (isset($datos['dni'])) {
                        $this->dni = $datos['dni'];
                    }
                    if (isset($datos['correo'])) {
                        $this->correo = $datos['correo'];
                    }
                    if (isset($datos['telefono'])) {
                        $this->telefono = $datos['telefono'];
                    }
                    if (isset($datos['direccion'])) {
                        $this->direccion = $datos['direccion'];
                    }
                    if (isset($datos['codigoPostal'])) {
                        $this->codigoPostal = $datos['codigoPostal'];
                    }
                    if (isset($datos['genero'])) {
                        $this->genero = $datos['genero'];
                    }
                    if (isset($datos['fechaNacimiento'])) {
                        $this->fechaNacimiento = $datos['fechaNacimiento'];
                    }
        
                    $resp = $this->modificarPaciente();
                    if ($resp) {
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "pacienteId" => $this->pacienteid
                        );
                        return $respuesta;
                    } else {
                        return $_respuestas->internalError();
                    }
                }
            } else {
                return $_respuestas->unauthorized("El Token que envio es invalido o ha caducado");
            }
        }
    }


    private function modificarPaciente()
    {
        $query = "UPDATE " . $this->table . " SET Nombre ='" . $this->nombre . "',Direccion = '" . $this->direccion . "', DNI = '" . $this->dni . "', CodigoPostal = '" .
        $this->codigoPostal . "', Telefono = '" . $this->telefono . "', Genero = '" . $this->genero . "', FechaNacimiento = '" . $this->fechaNacimiento . "', Correo = '" . $this->correo .
         "' WHERE PacienteId = '" . $this->pacienteid . "'";
        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
             return $resp;
        } else {
            return 0;
        }
    }


    public function delete($json)
    {
        $_respuestas = new Responses;
        $datos = json_decode($json, true);

        if (!isset($datos['token'])) {
            return $_respuestas->unauthorized();
        } else {
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if ($arrayToken) {
                if (!isset($datos['pacienteId'])) {
                    return $_respuestas->formatNotCorrect();
                } else {
                    $this->pacienteid = $datos['pacienteId'];
                    $resp = $this->eliminarPaciente();
                    if ($resp) {
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "pacienteId" => $this->pacienteid
                        );
                        return $respuesta;
                    } else {
                        return $_respuestas->internalError();
                    }
                }
            } else {
                return $_respuestas->unauthorized("El Token que envio es invalido o ha caducado");
            }
        }
    }


    private function eliminarPaciente()
    {
        $query = "DELETE FROM " . $this->table . " WHERE PacienteId= '" . $this->pacienteid . "'";
        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }


    private function buscarToken()
    {
        $query = "SELECT  TokenId,UsuarioId,Estado from usuarios_token WHERE Token = '" . $this->token . "' AND Estado = 'Activo'";
        $resp = parent::getData($query);
        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }


    private function actualizarToken($tokenid)
    {
        $date = date("Y-m-d H:i");
        $query = "UPDATE usuarios_token SET Fecha = '$date' WHERE TokenId = '$tokenid' ";
        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }
}
