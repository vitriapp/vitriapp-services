<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/7/30 11:46:23
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\v1;

use services\v1\model\Patients;

/**
 * Class General
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class General
{

    /**
     * Method
     *
     * This method is useful for use some required method
     *
     * @param string $method name to use.
     *
     * @return string
     */
    final public function method(string $method): string
    {
        if ($method === 'pacientes') {
            return "Patients";
        }
        return $method;
    }

    /**
     * Object select class
     *
     * This method is useful for get method class
     *
     * @param string $object name object class
     *
     * @return object
     */
    final public function objectClass(string $object): object
    {
        $result = strtolower($object);
        if ($result==='patients') {
            include_once '../model/Patients.php';
            ${$result} = new Patients();
        }
        return ${$result};
    }
}
