<?php
declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @Date: 2021/7/24 11:18:9
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @category Developer
 * @package  Vitriapp
 * @license  Commercial
 */

namespace services\v1;

use JsonException;
use services\master\Patients;
use services\set\Constant;

/**
 * Class Get for Patients
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Get
{

    /**
     * Get method for patients
     *
     * This method is useful for get patients
     *
     * @param int $value for various patients
     *
     * @return mixed
     */
    final public function variousPatients(int $value): int
    {
        $patients = new Patients();
        $list_patients = '';
        $pages = $value;
        try {
            $list_patients = $patients->listPatients($pages);
        } catch (JsonException $exception) {
            log($exception->getMessage());
        }
        header(Constant::CONTENT_TYPE_JSON);
        try {
            print_r(json_encode($list_patients, JSON_THROW_ON_ERROR), false);
        } catch (JsonException $exception) {
            log($exception->getMessage());
        }

        return http_response_code(200);
    }

    /**
     * Get method for one patient
     *
     * This method is useful for get specific one patient
     *
     * @param int $id_user for one patient
     *
     * @return mixed
     */
    final public function onePatients(int $id_user): int
    {
        $patient = new Patients();
        $data_patients = '';
        $id_patients = $id_user;
        try {
            $data_patients = $patient->getPatient($id_patients);
        } catch (JsonException $exception) {
            log($exception->getMessage());
        }
        header(Constant::CONTENT_TYPE_JSON);
        try {
            print_r(json_encode($data_patients, JSON_THROW_ON_ERROR), false);
        } catch (JsonException $exception) {
            log($exception->getMessage());
        }

        return http_response_code(200);
    }
}
