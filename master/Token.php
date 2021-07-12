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

require_once __DIR__ . '/connection/Connection.php';

/**
 * Class Token
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Token
{

    function updateToken($datetime)
    {
        $process = new Process();
        $query = "update usuarios_token set Estado = 'Inactivo' WHERE  Fecha < '$datetime'";
        $verifica = $process->nonQuery($query);
        if ($verifica) {
            $this->escribirEntrada($verifica);
            return $verifica;
        } else {
            return 0;
        }
    }

    function crearTxt($direccion)
    {
           $archivo = fopen($direccion, 'w') or die("error al crear el archivo de registros");
           $texto = "------------------------------------ Registros del CRON JOB ------------------------------------ \n";
           fwrite($archivo, $texto) or die("no pudimos escribir el registro");
           fclose($archivo);
    }

    function escribirEntrada($registros)
    {
        $direccion = "../cron/registros/registros.txt";
        if (!file_exists($direccion)) {
            $this->crearTxt($direccion);
        }
        /* crear una entrada nueva */
        $this->escribirTxt($direccion, $registros);
    }

    function escribirTxt($direccion, $registros)
    {
        $date = date("Y-m-d H:i");
        $archivo = fopen($direccion, 'a') or die("error al abrir el archivo de registros");
           $texto = "Se modificaron $registros registro(s) el dia [$date] \n";
           fwrite($archivo, $texto) or die("no pudimos escribir el registro");
           fclose($archivo);
    }
}
