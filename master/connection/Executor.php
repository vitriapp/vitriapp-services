<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/6/14 0:3:34
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\master\connection;

use JsonException;

require_once __DIR__ . '/Connection.php';

/**
 * Class Process
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Executor extends Connection
{

    /**
     * Converter utf8
     *
     * This method is useful for converter text to utf8
     *
     * @param array $array data to converter
     *
     * @return mixed
     */
    private function converterUtf(array $array): array
    {
        array_walk_recursive(
            $array,
            static function (&$value) {
                if (!mb_detect_encoding($value, 'UTF-8', true)) {
                    $value = utf8_encode($value);
                }
            }
        );
        return $array;
    }

    /**
     * Get data
     *
     * This method is useful for get data user
     *
     * @param string $query execute in database for get data
     *
     * @return mixed
     * @throws JsonException
     */
    final public function getData(string $query): array
    {
        $this->systemAccess();
        $results = $this->connect->query($query);
        $result = [];
        foreach ($results as $value) {
            $result[] = $value;
        }
        return $this->converterUtf($result);
    }

    /**
     * Non query
     *
     * This method is useful for execute actions in database
     *
     * @param string $query execute in database for actions database
     *
     * @return mixed
     * @throws JsonException
     */
    final public function nonQuery(string $query): int
    {
        $this->systemAccess();
        $this->connect->query($query);
        return $this->connect->affected_rows;
    }

    /**
     * Non query id
     *
     * This method is useful for execute actions in database with one data
     *
     * @param string $query execute in database for actions database with one data
     *
     * @return mixed
     * @throws JsonException
     */
    final public function nonQueryId(string $query) : int
    {
        $this->systemAccess();
        $this->connect->query($query);
        $registers = $this->connect->affected_rows;
        if ($registers >= 1) {
            return $this->connect->insert_id;
        }
        return 0;
    }

    /**
     * Encrypt data
     *
     * This method is useful for crypt data
     *
     * @param string $string text to crypt
     *
     * @return mixed
     */
    final public function encryptData(string $string) : string
    {
        return bin2hex(sha1(md5(sha1($string))));
    }
}
