<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/8/3 9:8:20
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\v1\model;

use JsonException;

/**
 * Interface IModel
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
interface IModel
{

     /**
     * List
     *
     * This method is useful for get list register from database
     *
     * @param int $page for show quantity registers
     *
     * @return mixed | int
     * @throws JsonException
     */
    public function list(int $page = 1): array;

    /**
     * Get
     *
     * This method is useful for get one register from code
     *
     * @param int $codes for show data from code patient
     *
     * @return mixed | int
     * @throws JsonException
     */
    public function get(int $codes): array;

    /**
     * Get data register
     *
     * This method is useful for get data for use to store procedure
     *
     * @return array
     */
    public function getData(): array;

    /**
     * Get information response
     *
     * This method is useful for get data for use to store procedure
     *
     * @param string $process message process class
     * @param string $message message successfully action
     *
     * @return array
     */
    public function getInformationResponse(string $process, string $message): array;

    /**
     * Process BD actions
     *
     * This method return result execute query insert in database
     *
     * @param string $action execute process in database
     *
     * @return string | int | mixed
     * @throws JsonException
     */
    public function processBdActions(string $action): int;

    /**
     * Post validate
     *
     * This method is useful validate token for performed action in database
     *
     * @param string $json for show data from code patient
     *
     * @return mixed
     * @throws JsonException
     */
    public function postValidate(string $json): array;

    /**
     * Put validate
     *
     * This method is useful validate token for performed action in database
     *
     * @param string $json for show data from code patient
     *
     * @return mixed
     * @throws JsonException
     */
    public function putValidate(string $json): array;

    /**
     * Delete validate
     *
     * This method is useful validate token for performed action in database
     *
     * @param string $json for show data from code
     *
     * @return mixed
     * @throws JsonException
     */
    public function deleteValidate(string $json): array;
}
