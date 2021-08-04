<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/7/31 10:43:46
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\set;

/**
 * Class Regular
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Regular
{

    final public function results(string $key = null): string
    {
        $return['pacientes'] = 'Patients';
        $return['citas']     = 'Dates';

        if (!array_key_exists($key, $return)) {
            return '';
        }
        return $return[$key];
    }
}
