<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/7/25 9:32:57
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\master;

use JsonException;
use services\master\connection\Executor;
use Symfony\Component\Filesystem\Exception\IOException;

require_once '../master/connection/Executor.php';

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
     * @throws JsonException
     */
    final public function updateToken(string $datetime): int
    {
        $table = 'usuarios_token';
        $status = 'Inactivo';
        $process = new Executor();
        $query = 'UPDATE ' . $table . "
                SET Estado = '$status' WHERE  Fecha < '$datetime'";
        $verify = $process->nonQuery($query);
        if ($verify>0) {
            $this->enterWrite($verify);
            return $verify;
        }
        return 0;
    }

    /**
     * Enter write
     *
     * This method is useful for write text in file
     *
     * @param int $registers file to write
     *
     * @return mixed | int | string
     */
    final public function enterWrite(int $registers):string
    {
        try {
            $filename = 'registros/registros.txt';
            if (!file_exists($filename)) {
                $files = fopen($filename, 'wb');
                $words = '---------- Registros del CRON JOB ---------'."\n";
                fwrite($files, $words);
                fclose($files);
            }
            $datetime = date('Y-m-d H:i');
            $files = fopen($filename, 'ab');
            $words = 'Editados '.$registers .' dato(s) el dia ['.$datetime.']'."\n";
            fwrite($files, $words);
            fclose($files);
        } catch (IOException $exception) {
            log((float)$exception);
        }
        return '';
    }
}
