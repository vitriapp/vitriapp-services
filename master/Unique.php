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
 * Class Unique
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Unique
{

    /**
     * Update token
     *
     * This method is useful for update token
     *
     * @param string $datetime for update time
     *
     * @return mixed | int
     */
    final public function updateToken(string $datetime): int
    {
        $table = 'usuarios_token';
        $status = 'Inactivo';
        $process = new Process();
        $query = 'UPDATE ' . $table . "
                SET Estado = '$status' WHERE  Fecha < '$datetime'";
        $verify = $process->nonQuery($query);
        if ($verify) {
            $this->enterWrite($verify);
            return $verify;
        }
        return 0;
    }

    /**
     * Create txt
     *
     * This method is useful for update token
     *
     * @param string $files file to write
     *
     * @return mixed | int
     */
    final public function createTxt(string $files):string
    {
           $files = fopen($files, 'wb') or die('Error creando archivo.');
           $words = '---------- Registros del CRON JOB --------- \n';
           fwrite($files, $words) or die('No pudimos escribir el registro');
           fclose($files);
           return '';
    }

    /**
     * Enter write
     *
     * This method is useful for write text in file
     *
     * @param string $registers file to write
     *
     * @return mixed | int
     */
    final public function enterWrite(string $registers):string
    {
        $directory_file = '../cron/registros/registros.txt';
        if (!file_exists($directory_file)) {
            $this->createTxt($directory_file);
        }
        $this->writeTxt($directory_file, $registers);
        return '';
    }

    /**
     * Enter write
     *
     * This method is useful for write text in file
     *
     * @param string $registers     data
     * @param string $directoryFile file to write
     *
     * @return mixed | int
     */
    final public function writeTxt(string $registers, string $directoryFile):string
    {
        $datetime = date('Y-m-d H:i');
        $files = fopen($directoryFile, 'ab') or die("Error abrir archivo registro");
           $words = 'Editados '.$registers .'registro(s) el dia ['.$datetime.'] \n';
           fwrite($files, $words) or die('No pudimos escribir el registro');
           fclose($files);
           return '';
    }
}
