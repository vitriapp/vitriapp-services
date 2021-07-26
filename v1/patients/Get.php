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

namespace services\v1;

use JsonException;
use services\v1\patients\Patients;
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
        $listPatients = '';
        $pages = $value;
        try {
            $listPatients = $patients->listPatients($pages);
        } catch (JsonException $exception) {
            log($exception->getMessage());
        }
        header(Constant::CONTENT_TYPE_JSON);
        try {
            print_r(json_encode($listPatients, JSON_THROW_ON_ERROR), false);
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
     * @param int $idUser for one patient
     *
     * @return mixed
     */
    final public function onePatients(int $idUser): int
    {
        $patient = new Patients();
        $dataPatients = '';
        $idPatients = $idUser;
        try {
            $dataPatients = $patient->getPatient($idPatients);
        } catch (JsonException $exception) {
            log($exception->getMessage());
        }
        header(Constant::CONTENT_TYPE_JSON);
        try {
            print_r(json_encode($dataPatients, JSON_THROW_ON_ERROR), false);
        } catch (JsonException $exception) {
            log($exception->getMessage());
        }

        return http_response_code(200);
    }
}
