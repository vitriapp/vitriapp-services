<?php

declare(strict_types=1);

namespace services\master\libs;

/**
 * *
 *  * PHP version 7.4
 *  *
 *  * @Date: 2021/6/15 1:27:43
 *  * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 *  * @category Developer
 *  * @package  Vitriapp
 *  * @license  Commercial
 *
 */
class Utils
{

    final public function getString(array $array, string $index, string $default = null): string
    {
        if (isset($array[$index]) && \strlen($value = trim($array[$index])) > 0) {
            return get_magic_quotes_gpc() ? stripslashes($value) : $value;
        }
        return $default;
    }
}
