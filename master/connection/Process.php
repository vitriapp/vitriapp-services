<?php

declare(strict_types=1);

/*
 *PHP version 7.4
 *@Date: 2021/6/14 0:3:34
 *@author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 *@category Developer
 *@package  Vitriapp
 *@license  Commercial
 */

namespace services\master\connection;

include __DIR__ . '/Connection.php';

/**
 * Class Process
 */
class Process extends Connection
{
    private function converterUTF8(array $array): array
    {
        array_walk_recursive($array, static function (&$item_list) {
            if (!mb_detect_encoding($item_list, 'UTF-8', true)) {
                $item_list = utf8_encode($item_list);
            }
        });
        return $array;
    }

    /**
     * @param $query
     * @return mixed
     */
    final public function getData(string $query): array
    {
        $this->systemAccess();
        $results = $this->connect->query($query);
        $result = [];
        foreach ($results as $value) {
            $result[] = $value;
        }
        return $this->converterUTF8($result);
    }

    /**
     * @param $query
     * @return mixed
     */
    final public function nonQuery(string $query): int
    {
        $this->systemAccess();
        $this->connect->query($query);
        return $this->connect->affected_rows;
    }

    final public function nonQueryId(string $query) : int
    {
        $this->systemAccess();
        $this->connect->query($query);
        $rows_data = $this->connect->affected_rows;
        if ($rows_data >= 1) {
            return $this->connect->insert_id;
        }
        return 0;
    }

    final public function encryptData(string $string) : string
    {
        return bin2hex(sha1(md5(sha1($string))));
    }
}
