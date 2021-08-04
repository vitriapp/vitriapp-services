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
    public function list(int $page = 1): array;
    public function get(int $codes): array;
    public function postValidate(string $json): array;
    public function putValidate(string $json): array;
    public function deleteValidate(string $json): array;
    public function insert(): int;
    public function update(): int;
    public function delete(): int;
}
