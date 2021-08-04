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

require_once '../../master/connection/Executor.php';
require_once '../../master/Responses.php';
require_once '../General.php';

/**
 * Class Dates
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Dates
{
    /**
     * List dates
     *
     * This method is useful for get list dates from database
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
        $query = "CALL get_all_dates($initial, $quantity)";
        $registers = $process->getData($query);
        return ($registers);
    }

    /**
     * Get date
     *
     * This method is useful for get one date from code
     *
     * @param int $codes for show data from code date
     *
     * @return mixed | int
     * @throws JsonException
     */
    final public function get(int $codes):array
    {
        $process = new Executor();
        $query = "CALL get_date($codes)";
        return $process->getData($query);
    }
}
